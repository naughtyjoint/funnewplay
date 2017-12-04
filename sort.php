<?php

//bubble sort氣泡排序法
//    for($k=0;$k<10;$k++){
//        $NumRow[$k] = rand(1,300);
//        echo $NumRow[$k].' ';
//    }
//    echo '</br>';
//   $NumRowcount = count($NumRow);
//    echo '</br>';

//        for($i=0;$i<$NumRowcount;$i++){
//             for($j=0;$j<$NumRowcount-1;$j++){
                
                
//                 if($NumRow[$j]>$NumRow[$j+1]){
//                     $a=$NumRow[$j];
//                     $NumRow[$j]=$NumRow[$j+1];
//                     $NumRow[$j+1]=$a;
                    
//                 }
                                
//             }
            
           
//         }
           
//     for($k=0;$k<10;$k++){
//         echo $NumRow[$k].' ';
//     }
// echo 'finish';



//印出1~100內的所有質數
// for($a=2;$a<100;$a++){
//     $t=1;
//     for($b=1;$b<=$a;$b++){
//         if($a%$b==0){
//             $t++ ;
//         }
//     }   if($t<=3)
//     echo $a.' ';
// }


//-------------------------------------------------------------------
//const常數宣告範例
// const ONE = 1;

// class foo {
//     // As of PHP 5.6.0
//     const TWO = ONE * 2;
//     const THREE = ONE + self::TWO;
//     const SENTENCE = 'The value of THREE is '.self::THREE;
// }

// $name = 'foo';
// echo $name::SENTENCE;


//-------------------------------------------------------------------
//Scope Resolution Operator(::)使用範例
// class MyClass {
//     const CONST_VALUE = 'A constant value';
// }

// $classname = 'MyClass';
// echo $classname::CONST_VALUE; // As of PHP 5.3.0
// echo MyClass::CONST_VALUE;

//var_dump用法
// $a = array(1, 2, array("a", "b", "c"));
// var_dump($a);



?>