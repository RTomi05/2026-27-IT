<?php
    echo strlen("Hello world!"); // visszaadja a szöveg hosszát

    echo str_word_count("Hello world!");
    var_dump(str_word_count("Hello drága world!",1,"á"));

    echo strpos("Hello world!", "world");
    var_dump(strpos("Hello world!", "világ"));

    $str = "Hello world. It's a beautiful day.";
    print_r (explode(" ",$str));

    $number = 9;
    $str = "Beijing";
    $file = fopen("test.txt","w");
    echo fprintf($file,"There are %u million bicycles in %s.",$number,$str);

    $str = '&lt;a href=&quot;https://www.w3schools.com&quot;&gt;w3schools.com&lt;/a&gt;';
    echo html_entity_decode($str);
    $str = '<a href="https://www.w3schools.com">Go to w3schools.com</a>';
    echo htmlentities($str);

    $arr = array('Hello','World!','Beautiful','Day!');
    echo implode(" ",$arr);
?>