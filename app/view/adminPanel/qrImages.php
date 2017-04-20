<?php
class qrImages {
    private $paths; 
    
    function __construct($paths) {
        $this->paths = $paths;
    }
    
    public function show() {
        $i = 0;
        foreach ($this->paths as $code => $path) {
            if ($i % 4 == 0) {
            echo "<div class=row>\n";
            }
            echo '<div class = "col-md-3">' . "\n";
            echo '<legend><a href="mailto:' . $path[3] . '">' . $path[2] . ' ' . $code . '</a></legend>' . "\n";
            echo '<a class="thumbnail" href="' . $path[0] . '">' . "\n";
            echo '<img src="' . $path[1] . '" alt="' . $code . '">' . "\n";
            echo "</a>\n";
            echo "</div>\n";
            if ($i%4==3 ) {
                echo "</div>\n";
            }
            $i++;
        }
        if (count($code) % 4 != 0) {
            echo "</div>\n";
        }
    }
}
