/*function toPHP(deck){
	alert("hej");
	location.search = '?deckName='+deck;
	console.log(location.search());
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){

		}
	}
	xmlhttp.open("GET", "logged_in.php?deckName="+deck, true);
	xmlhttp.send();
}*/

function addDeck(){
	var name = document.getElementById('newDeckName').value;
	if(name == "")
		return false;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){

		}
	}
	xmlhttp.open("GET", "addDeck.php?q="+name, true);
	xmlhttp.send();
}

function addCard(){
	var front = document.getElementById('front').value;
	var back = document.getElementById('back').value;
	var e = document.getElementById('deckSelect');
	var deck = e.options[e.selectedIndex].value;
	if(front == "" || back == "")
			return false;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
		}
	}
	xmlhttp.open("GET", "addCard.php?f="+front+"&b="+back+"&d="+deck, true);
	xmlhttp.send();
}

function nextCard(){
	var e = document.getElementById('deckSelect');
	var deck = e.options[e.selectedIndex].value;
	var curText = document.getElementById('current_card').innerHTML;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = JSON.parse(this.responseText);
			console.log(response);
			document.getElementById('current_card').innerHTML = response[Math.floor(Math.random()*response.length)];
		}
	}
	xmlhttp.open("GET", "nextCard.php?d="+deck+"&t="+curText,true);
	xmlhttp.send();
}