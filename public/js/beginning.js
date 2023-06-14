function startTypewriter() {
    // Clear previous content
    textLocationone.innerHTML = '';
    textLocationtwo.innerHTML = '';
    textLocationthree.innerHTML = '';
    textLocationfour.innerHTML = '';
  
    // Start displaying text gradually with delays
    displayTextone();
  }
  
  function displayTextone() {
    if (indexone < textone.length) {
      // Append one character at a time
      textLocationone.innerHTML += textone.charAt(indexone);
      indexone++;
  
      // Wait for a certain duration before appending the next character
      setTimeout(displayTextone, 30);
    } else {
      // Once the first text is fully displayed, start displaying the second text
      setTimeout(displayTexttwo, 1000);
    }
  }
  
  function displayTexttwo() {
    if (indextwo < texttwo.length) {
      // Append one character at a time
      textLocationtwo.innerHTML += texttwo.charAt(indextwo);
      indextwo++;
  
      // Wait for a certain duration before appending the next character
      setTimeout(displayTexttwo, 30);
    } else {
      // Once the second text is fully displayed, start displaying the third text
      setTimeout(displayTextthree, 1000);
    }
  }
  
  function displayTextthree() {
    if (indexthree < textthree.length) {
      // Append one character at a time
      textLocationthree.innerHTML += textthree.charAt(indexthree);
      indexthree++;
  
      // Wait for a certain duration before appending the next character
      setTimeout(displayTextthree, 30);
    } else {
      // Once the third text is fully displayed, start displaying the fourth text
      setTimeout(displayTextfour, 1000);
    }
  }
  
  function displayTextfour() {
    if (indexfour < textfour.length) {
      // Append one character at a time
      textLocationfour.innerHTML += textfour.charAt(indexfour);
      indexfour++;
  
      // Wait for a certain duration before appending the next character
      setTimeout(displayTextfour, 30);
    }
  }
  
  const textLocationone = document.querySelector("#one");
  const textLocationtwo = document.querySelector("#two");
  const textLocationthree = document.querySelector("#three");
  const textLocationfour = document.querySelector("#four");
  const textone = "Select your first Demon";
  const texttwo = "Hera";
  const textthree = "Aku-Aku";
  const textfour = "Minotor";
  
  let indexone = 0;
  let indextwo = 0;
  let indexthree = 0;
  let indexfour = 0;
  
  startTypewriter();