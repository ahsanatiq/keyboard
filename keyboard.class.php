<?php

/*
 * Class Keyboard
 */

class keyboard
{
    /*
     * Speical keys to handle differently
     */
    private $specialKeys = array(
        'SP' => array(
            'ascii' => '32',
            'neighbours' => array('>', '#', 'I', '.'),
        ),
        'BS' => array(
            'ascii' => '8',
            'neighbours' => array('=', '-', 'Z', '`'),
        ),
    );

    /*
     * Keyboard number of rows and Columns
     */
    private $nRows = 4;
    private $nColumns = 26;

    /*
     * To create keys of the keyboard and store it in single-dimension array
     */
    public function makeKeys()
    {
        for ($i = 65; $i <= 90; $i++) {
            $keys[] = chr($i);
        }
        for ($i = 97; $i <= 122; $i++) {
            $keys[] = chr($i);
        }
        for ($i = 48; $i <= 57; $i++) {
            $keys[] = chr($i);
        }
        $chars = '!@#$%^&*()?/|\\+-';
        for ($i = 0; $i < strlen($chars); $i++) {
            $keys[] = $chars[$i];
        }
        $chars = '`~[]{}<>';
        for ($i = 0; $i < strlen($chars); $i++) {
            $keys[] = $chars[$i];
        }
        for ($i = 0; $i <= 7; $i++)
            $keys[] = "SP";
        $chars = '.,;:\'"_=';
        for ($i = 0; $i < strlen($chars); $i++) {
            $keys[] = $chars[$i];
        }
        for ($i = 0; $i <= 1; $i++)
            $keys[] = "BS";

        $this->keys = $keys;
    }

    /*
     * convert single dimensional array of keyboard keys to 2-dimensional array for layout and graph mapping purpose
     */
    public function makeKeyboard()
    {
        $this->makeKeys();
        for ($i = 0; $i < $this->nRows; $i++) {
            for ($j = 0; $j < $this->nColumns; $j++) {
                $this->keyboard[$i][$j] = $i * $this->nColumns + $j;
            }
        }
    }

    /*
     * Create vertices of graph from 2 dimensional array of keyboard characters
     */
    public function makeGraph()
    {
        # collecting all the indexes of special characters
        foreach ($this->specialKeys as $spKey => $spVal) {
            $spIndex = array_keys($this->keys, $spKey); // Search for SP Char from the original keys
            if (count($spIndex) > 0) {
                $this->specialKeys[$spKey]['keys'] = $spIndex; // All the key indexes of the SP Char
                $this->specialKeys[$spKey]['key'] = $spIndex[0]; //The first key index of the SP Char
            }

        }

        # calculate the neighbours for each node
        for ($i = 0; $i < $this->nRows; $i++) {
            for ($j = 0; $j < $this->nColumns; $j++) {

                # Check for boundry limits
                $left = $j - 1;
                $left = ($left < 0 ? $this->nColumns - 1 : $left);
                $right = $j + 1;
                $right = ($right > $this->nColumns - 1 ? 0 : $right);
                $up = $i - 1;
                $up = ($up < 0 ? $this->nRows - 1 : $up);
                $down = $i + 1;
                $down = ($down > $this->nRows - 1 ? 0 : $down);

                # neighbours format (LEFT, TOP, BOTTOM, RIGHT)
                $neighbours = array($this->keyboard[$i][$left], $this->keyboard[$up][$j], $this->keyboard[$down][$j], $this->keyboard[$i][$right]);

                # before inserting the node into graph check for SP chars
                $boolInsert = true;
                foreach ($this->specialKeys as $spKey => $spVal) {
                    # check if node is Special Char, if yes then don't insert now
                    if (in_array($this->keyboard[$i][$j], $spVal['keys'])) {
                        $boolInsert = false;
                        break;
                    }
                    # check if any of the nodes is pointing to on the special chars, if yes then point to original first index
                    foreach ($neighbours as $neighbourKey => $neighbour) {
                        if (in_array($neighbour, $spVal['keys'])) {
                            $neighbours[$neighbourKey] = $spVal['key'];
                        }
                    }
                }
                if ($boolInsert) {
                    # insert node into graph
                    $this->graph[$this->keyboard[$i][$j]] = array('value' => $this->keys[$this->keyboard[$i][$j]], 'neighbours' => $neighbours);
                }
            }
        }
        # insert special chars node into graph
        foreach ($this->specialKeys as $spKey => $spVal) {
            $neighbours = array(
                array_search($spVal['neighbours'][0], $this->keys),
                array_search($spVal['neighbours'][1], $this->keys),
                array_search($spVal['neighbours'][2], $this->keys),
                array_search($spVal['neighbours'][3], $this->keys),
            );
            $this->graph[$spVal['key']] = array('value' => $spKey, 'neighbours' => $neighbours);
        }
    }

    /*
     * Draw Keyboard for illustration purpose
     */
    public function drawKeyboard($byKeys = false)
    {
        echo '<table border="1">';
        foreach ($this->keyboard as $key => $value) {
            echo '<tr>';
            foreach ($value as $val) {
                echo '<td width="30">' . ($byKeys ? $val : $this->keys[$val]) . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }

    /*
     * Take input as string of characters and return its commands
     */
    public function makeCommands($sentence)
    {
        $commands = array();
        $cSentence = strlen($sentence);
        for ($i = 1; $i < $cSentence; $i++) {


            $firstChar = $sentence[$i - 1];
            $secondChar = $sentence[$i];
            #handle special char keys given in the input string
            foreach ($this->specialKeys as $spKey => $spValue) {
                if (ord($firstChar) == $spValue['ascii']) {
                    $firstChar = $spKey;
                }
                if (ord($secondChar) == $spValue['ascii']) {
                    $secondChar = $spKey;
                }
            }

            $firstIndex = array_search($firstChar, $this->keys);
            $secondIndex = array_search($secondChar, $this->keys);
            if ($firstIndex !== false && $secondIndex !== false) {
                if ($i == 1)
                    $commands[] = 'Enter(' . $firstChar . ')';

                # find the shortest path between two nodes
                $paths = $this->findPath($firstIndex, $secondIndex);
                if ($paths) {
                    foreach ($paths as $path) {
                        if (isset($path['command']))
                            $commands[] = $path['command'];
                    }
                } else {
                    $commands[] = 'PATH NOT FOUND(' . $firstChar . $secondChar . ')';
                }
            } else {
                $commands[] = 'CHARACTER NOT FOUND(' . $firstChar.$firstIndex . $secondChar.$secondIndex  . ')';
            }

        }
        return implode(' - ', $commands);
    }

    /*
     * Calculate and return back the shortest path & commands between two nodes
     */
    function findPath($startIndex, $endIndex)
    {
        $queue = array();
        # Enqueue the path
        array_unshift($queue, array(
            array('index' => $startIndex)
        ));
        $visited = array($startIndex);

        while (count($queue) > 0) {
            $path = array_pop($queue);

            # Get the last node on the path
            # so we can check if we're at the end
            $lastNode = $path[count($path) - 1];
            if ($lastNode['index'] == $endIndex) {
                $path[] = array('index' => $endIndex, 'command' => 'Enter(' . $this->keys[$endIndex] . ')');
                return $path;
            }
//            print_r($this->graph[$lastNode['index']]['neighbours']);
            foreach ($this->graph[$lastNode['index']]['neighbours'] as $neighbourKey => $neighbourIndex) {

                if (!in_array($neighbourIndex, $visited)) {
                    $visited[] = $neighbourIndex;

                    switch ($neighbourKey) {
                        case 0:
                            $command = 'LEFT';
                            break;
                        case 1:
                            $command = 'UP';
                            break;
                        case 2:
                            $command = 'DOWN';
                            break;
                        case 3:
                            $command = 'RIGHT';
                            break;
                        default:
                            $command = 'COMMAND UNDEFINED';
                    }
                    # Build new path appending the neighbour then and enqueue it
                    $new_path = $path;
                    $new_path[] = array('index' => $neighbourIndex, 'command' => $command);

                    array_unshift($queue, $new_path);
                }
            };
        }

        return false;
    }

}

?>