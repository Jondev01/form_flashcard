window.onload=clearCard;

function addDeck(input=false){
	var name;
	if(input!= false){
		name = document.getElementById('newDeckName').value;
	} else{
		name = prompt("Enter the name of the new deck");
	}
	if(name == null)
		return false;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			window.location.reload();
		}
	}
	xmlhttp.open("GET", "php/addDeck.php?q="+name, true);
	xmlhttp.send();
	return false;
}

function addCard(input = false){
	var front, back;
	if(input != false){
		front = document.getElementById('front').value;
		back = document.getElementById('back').value; 
		if(front=="" || back=="")
			return false;
	} else{
		front = prompt("Enter the front side of the card");
		back = prompt("Enter the back side of the card");
	}
	var e = document.getElementById('deckSelect');
	var deckId = e.options[e.selectedIndex].value;
	if(front==null || back==null || !(deckId>0))
		return false;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			if(input!=false){
				updateCardList();
				document.getElementById('addCard').reset();
			}
			return false;
		}
	}
	xmlhttp.open("GET", "php/addCard.php?f="+front+"&b="+back+"&d="+deckId, true);
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
	xmlhttp.open("GET", "php/nextCard.php?d="+deck+"&t="+curText,true);
	xmlhttp.send();
	return false;
}

function flipCard(){
	var curText = document.getElementById('current_card').innerHTML;
	if(curText == "")
		return false;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var response = JSON.parse(this.responseText);
			if(response[0] == 'front'){
				document.getElementById('card_container').style.backgroundColor = 'white';
				document.getElementById('current_card').style.backgroundColor = 'white';
			}
			else if(response[0] == 'back'){
				document.getElementById('card_container').style.backgroundColor = '#eee';
				document.getElementById('current_card').style.backgroundColor = '#eee';
			}
			document.getElementById('current_card').innerHTML = response[1];
		}
	}
	xmlhttp.open("GET", "php/flipCard.php?t="+curText,true);
	xmlhttp.send();
	return false;
}

function deleteCard(input = false){
	var cardId;
	if(input != false)
		cardId=input;
	else if(document.getElementById('current_card').innerHTML == "" || !confirm("Delete this card?"))
		return false;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			
		}
	}
	xmlhttp.open("GET", "php/deleteCard.php?c="+cardId,true);
	xmlhttp.send();
	return false;
}

function deleteCards(){
	var e = document.getElementById('cardSelect');
	var cardList = e.selectedOptions;
	for(let i=0;i<cardList.length;i++)
		deleteCard(cardList[i].value);
	updateCardList();
}

function deleteDeck(){
	var e = document.getElementById('deckSelect');
	var deckId = e.options[e.selectedIndex].value;
	if(!(deckId >0) || !confirm("Delete the current deck?"))
		return false;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			window.location.reload();
		}
	}
	xmlhttp.open("GET", "php/deleteDeck.php?d="+deckId,true);
	xmlhttp.send();
	return false;
}

function clearCard(){
	if(document.getElementById('current_card')==null)
		return false;
	document.getElementById('current_card').innerHTML = "";
	document.getElementById('card_container').style.backgroundColor = 'white';
	document.getElementById('current_card').style.backgroundColor = 'white';
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
		}
	}
	xmlhttp.open("GET", "php/clearCard.php",true);
	xmlhttp.send();
}

function updateCardList(){
	var e = document.getElementById('deckSelect');
	var deckId = e.value;
	if(deckId == 0)
		return false;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			if(this.responseText==undefined)
				return false;
			var response = JSON.parse(this.responseText);
			var e = document.getElementById("cardSelect");
			e.innerHTML="";
			for(let i=0;i<response.length;i++){
				e.innerHTML += '<option value="'+response[i].id+'">'+response[i].front+"\t-\t"+response[i].back+'</option>';
			}
		}
	}
	xmlhttp.open("GET", "php/updateCardList.php?d="+deckId,true);
	xmlhttp.send();
	return false;
}