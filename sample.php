<html>
<head>
<script type="text/javascript">

var popupWindow=null;

function child_open()
{ 
popupWindow =window.open('new.php',"_blank","directories=no, status=no, menubar=no, scrollbars=yes, resizable=no,width=600, height=280,top=200,left=200");
}
function parent_disable() {
if(popupWindow && !popupWindow.closed)
popupWindow.focus();
}
</script>
</head>
<body onFocus="parent_disable();" onclick="parent_disable();">
    <a href="javascript:child_open()">Click me</a>
</body>    
</html>