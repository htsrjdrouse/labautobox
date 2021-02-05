<script type = "text/javascript">
 var client = new Messaging.Client("<?=$_SERVER['SERVER_ADDR']?>", 8080, "myclientid_" + parseInt(Math.random() * 100, 10));
 client.onConnectionLost = function (responseObject) {
 };
 client.onMessageArrived = function (message) {
     $('#messages').append('<span>Topic: ' + message.destinationName + '  | ' + message.payloadString + '</span><br/>');
 };
 //Connect Options
 var options = {
     timeout: 3,
     //Gets Called if the connection has sucessfully been established
     onSuccess: function () {
         //alert("Connected");
     },
     //Gets Called if the connection could not be established
     onFailure: function (message) {
         alert("Connection failed: " + message.errorMessage);
     }
 };
 //Creates a new Messaging.Message Object and sends it to the HiveMQ MQTT Broker
 var publish = function (payload, topic, qos) {
     //Send your message (also possible to serialize it as JSON or protobuf or just use a string, no limitations)
     //var message = new Messaging.Message(payload);
     var speed = document.forms["smessage"]["speed"].value;
     var msg = document.forms["smessage"]["message"].value;
     msg = msg.replace(/ /g, "");
     msg = "G1".concat(msg).concat("F").concat(speed);
     var message = new Messaging.Message(msg);
     message.destinationName = topic;
     message.qos = qos;
     client.send(message);
 }
 </script>

<script>
$(document).ready(function() {
console.log( $('#result').text())
        $('.result').val( $('#result').text());
});
</script>
<? $mqttset = array("divmsg"=>"posmessages","topic"=>"testtopic","client"=>"client2")?>
<script type="text/javascript">
   var <?=$mqttset['client']?> = new Messaging.Client("<?=$_SERVER['SERVER_ADDR']?>", 8080, "my<?=$mqttset['client']?>id_" + parseInt(Math.random() * 100, 10));
   <?=$mqttset['client']?>.onConnectionLost = function (responseObject) {
   };
   <?=$mqttset['client']?>.onMessageArrived = function (message) {
	   $('#messages').text(' ' + message.payloadString.replace(/E.*/, "",));
            //$('.results').val( $('#messages').text());
	   $('.results').val( message.payloadString.replace(/E.*/, "",));
   };
    var options = {
      timeout: 3,
      onSuccess: function () {
	      <?=$mqttset['client']?>.subscribe('<?=$mqttset['topic']?>', {qos: 2}); 
      },
      onFailure: function (message) {
      }
     };
     <?=$mqttset['client']?>.connect(options);
</script>

<script>
$(document).ready(function(){
	$("#dam_return a").click(function(){
	var value = $(this).html();
	var input = $('#dam');
        console.log( $('#dam_return').text())
        //input.val(value);
        input.val($('#dam_return').text());
	});
});
</script>
<form name="smessage" action="" onsubmit="publish('subb !','labbot',2);">
<font size=1><b><div style="font-weight:bold" id="mytext"></b></div></font>

<div id="dam_return"><font size=1><a href="#" class="results"><div id="messages"></div></a></font></div><br>

<input id="dam" name="message" type="text" style="text-align:right;font-size:10px;"/>
<br>
<b>Speed:</b> <input  name="speed" type="text" value="3000" style="text-align:right;font-size:10px;" size=5/>
<!--<input type="submit" value="Submit">-->
<button type="submit" name="sendgcodecmd" value="Send gcode" class="btn btn-success btn-sm">Send gcode</button><br>
</form>
