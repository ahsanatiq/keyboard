<?php
require_once __DIR__.'/../keyboard.class.php';

class keyboardTest extends PHPUnit_Framework_TestCase {
	protected $kb;

	protected function setUp() {
        $this->kb = new keyboard();
        $this->kb->makeKeyboard();
		$this->kb->makeGraph();
    }

	public function testInitialization() {
		$this->assertInstanceOf('keyboard',$this->kb);
	}

	public function testHelloWorld() {

		$sentence = "Hello world!";
		$this->expectOutputString('Enter(H) - LEFT - LEFT - LEFT - DOWN - Enter(e) - RIGHT - RIGHT - RIGHT - RIGHT - RIGHT - RIGHT - RIGHT - Enter(l) - Enter(l) - RIGHT - RIGHT - RIGHT - Enter(o) - UP - UP - Enter(SP) - RIGHT - UP - UP - RIGHT - RIGHT - RIGHT - RIGHT - RIGHT - RIGHT - Enter(w) - LEFT - LEFT - LEFT - LEFT - LEFT - LEFT - LEFT - LEFT - Enter(o) - RIGHT - RIGHT - RIGHT - Enter(r) - LEFT - LEFT - LEFT - LEFT - LEFT - LEFT - Enter(l) - LEFT - LEFT - LEFT - LEFT - LEFT - LEFT - LEFT - LEFT - Enter(d) - DOWN - RIGHT - RIGHT - RIGHT - RIGHT - RIGHT - RIGHT - RIGHT - Enter(!)');
		echo $this->kb->makeCommands($sentence);

	}


	public function testExample1() {

		$sentence = "7&";
		$this->expectOutputString('Enter(7) - DOWN - RIGHT - RIGHT - UP - Enter(&)');
		echo $this->kb->makeCommands($sentence);

	}

	public function testExample2() {

		$sentence = "ABCD";
		$this->expectOutputString('Enter(A) - RIGHT - Enter(B) - RIGHT - Enter(C) - RIGHT - Enter(D)');
		echo $this->kb->makeCommands($sentence);

	}

	protected function tearDown() {
        unset($this->kb);
    }
}

?>