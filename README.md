keyboard
========
On Screen Keyboard:

A B C D E F G H I J K L M N O P Q R S T U V W X Y Z

a b c d e f g h i j k l m n o p q r s t u v w x y z

0 1 2 3 4 5 6 7 8 9 ! @ # $ % ^ & * ( ) ? / | \ + -

` ~ [ ] { } < > SPACE . , ; : ‘ “ _ = BS

The on-screen keyboard comes with the remote control:

Algorithm that calculates:

- The most efficient way to enter any given sentence using the least amount of key strokes. 

Although there might be more than one solution, you only have to give us one.

- The actual sequence of key-presses on the remote control for this solution.

The following rules apply:

- The initial position of the cursor is at the first character of the sentence that needs to be 

entered.

- Only one cursor key can be pressed on the remote control at the same time.

- When the cursor is on the top row and you press cursor-up on the remote control, the 

cursor will move to the corresponding column on the bottom row. Example: from E to {

- The same applies to the most left column, the most right column and the bottom-row 

when respectively cursor-right, cursor-left and cursor-down are pressed on the remote 

control.

- Special moves:

o When the cursor is on the space bar and cursor-down is pressed on the 

remote control, the cursor will move to I (capital i).

o When the cursor is on the space bar and cursor-up is pressed on the remote 

control, the cursor will move to #.

o When the cursor is on I, J, K, L, M, N, O or P and cursor-up is pressed on 

the remote control, the cursor will move to the space bar.

o When the cursor is on 8,9, !, @, #, $, % or ^ and cursor-down is pressed, 

the cursor will move to the space bar.

o When the cursor is on back space (BS) and cursor-down is pressed on the 

remote control, the cursor will move to Z. 

o When the cursor is on back space (BS) and cursor-up is pressed on the 

remote control, the cursor will move to -. 

o When the cursor is on Y or Z and cursor-up is pressed on the remote control, 

the cursor will move to back space (BS)

o When the cursor is on + or - and cursor-down is pressed on the remote control, 

the cursor will move to back space (BS)

Example 1 :

$sentence = ‘7&’;

$keyboard = new Keyboard();

$keyboard->findOptimumPath($sentence);

Should output one of the following:

Solution 1: ENTER (7) – DOWN – RIGHT – RIGHT – UP – ENTER (&)

Solution 2: ENTER (7) – RIGHT – DOWN – RIGHT – UP – ENTER (&)

Example 2:

$sentence = ‘ABCD’;

$keyboard = new Keyboard();

$keyboard->findOptimumPath($sentence);

Should output:

ENTER (A) – RIGHT – ENTER (B) – RIGHT – ENTER (C) – RIGHT – ENTER (D)
    
