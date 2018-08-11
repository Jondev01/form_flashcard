window.onload=clearCard;

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
	return false;
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
	return false;
}

function nextCard(){
	var e = document.getElementById('deckSelect');
	var deck = e.options[e.selectedIndex].value;
	var curText = document.getElementById('current_card').innerHTML;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('current_card').style.backgroundColor = 'white';
			document.getElementById('card_container').style.backgroundColor = 'white';
			document.getElementById('current_card').innerHTML = response;
		}
	}
	xmlhttp.open("GET", "nextCard.php?d="+deck+"&t="+curText,true);
	xmlhttp.send();
	return false;
}

function flipCard(){
	var curText = document.getElementById('current_card').innerHTML;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = JSON.parse(this.responseText);
			if(response[0] == 'front'){
				document.getElementById('card_container').style.backgroundColor = 'white';
				document.getElementById('current_card').style.backgroundColor = 'white';
			}
			else if(response[0] == 'back'){
				document.getElementById('card_container').style.backgroundColor = 'red';
				document.getElementById('current_card').style.backgroundColor = 'red';
			}
			document.getElementById('current_card').innerHTML = response[1];
		}
	}
	xmlhttp.open("GET", "flipCard.php?t="+curText,true);
	xmlhttp.send();
	return false;
}

function deleteCard(){
	if(document.getElementById('current_card').innerHTML == "")
		return false;
	if(!confirm("Delete this card?"))
		return false;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			nextCard();
		}
	}
	xmlhttp.open("GET", "deleteCard.php",true);
	xmlhttp.send();
	return false;
}

function clearCard(){
	document.getElementById('current_card').innerHTML = "";
	document.getElementById('card_container').style.backgroundColor = 'white';
	document.getElementById('current_card').style.backgroundColor = 'white';
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
		}
	}
	xmlhttp.open("GET", "clearCard.php",true);
	xmlhttp.send();
}