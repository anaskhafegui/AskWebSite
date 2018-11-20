<?php

    function lang($phrase) {

       static $lang = array (
       	
       'home'        => 'Home',

       'cat'         => 'Categories',

       'ITEMS'       => 'Items',

       'COMMENTS'    => 'Comments',
 
       'MEMBERS'     => 'Members',

       'STATISTICS'  =>'Statstics',

       'LOGS'        => 'Logs',

       '' => '',

       '' => ''
      );

       return $lang[$phrase];
   }
