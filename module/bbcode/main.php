<?php
return new class(){
    public $bbcode = [
        [
            '~\[b\](.*?)\[/b\]~s',
            '~\[i\](.*?)\[/i\]~s',
            '~\[u\](.*?)\[/u\]~s',
            '~\[quote\](.*?)\[/quote\]~s',
            '~\[size=(.*?)\](.*?)\[/size\]~s',
            '~\[color=(.*?)\](.*?)\[/color\]~s',
            '~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
            '~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s'
        ],
        [
            '<b>$1</b>',
            '<i>$1</i>',
            '<span style="text-decoration:underline;">$1</span>',
            '<pre>$1</'.'pre>',
            '<span style="font-size:$1px;">$2</span>',
            '<span style="color:$1;">$2</span>',
            '<a href="$1">$1</a>',
            '<img src="$1" alt="" />'
        ]
    ];
    public function parse($string){
        $string  = htmlspecialchars($string, ENT_QUOTES);
        return preg_replace($this->bbcode[0], $this->bbcode[1], $string);
    }
    public function addBBCode($bbcode, $html) : void{
        $this->bbcode[0][] = $bbcode;
        $this->bbcode[1][] = $html;
        return;
    }
}
?>