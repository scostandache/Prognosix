<?php
$content = simplexml_load_string(
    '<content>Acestea sunt notele la laboratorul  de inteligenta artificiala: <![CDATA[ </br><a href=\'download.php?to_dwnd=note_3A3_inteligenta_artificiala_laborator.csv\'>Fisier CSV</a>  </br><a href=\'download.php?to_dwnd=note_3A3_inteligenta_artificiala_laborator.pdf\'>Fisier PDF</a> ]]></content>'
);
echo (string) $content;

// or with parent element:

$foo = simplexml_load_string(
    '<foo><content><![CDATA[Hello, world!]]></content></foo>'
);
echo (string) $foo->content;