<html>
   <head> 
      <meta name="viewport" content="width=device-width, initial-scale=1"> 
      <script type="text/javascript">
    window.onload=function(){/*from  w w  w.j a v a  2  s.  com*/
//dd/mm/yyyy
var date = new Date();
console.log(date);
var month = date.getMonth();
console.log(month);
var day = date.getDate();
console.log(day);
var year = date.getFullYear();
console.log(year);

console.log(day+"/"+month+"/"+year);
    }

      </script> 
   </head> 
   <body> 
      <input type="date" id="date">  
   </body>
</html>