
let selectedMenu = "";
let subGenre = "";
let subGenreNames = [];
let adultKids = "";
let summary = subGenre;
let choice = 0;


const pizzaStart = () => 
{
   // Step 1 - Welcome and introduction
   alert( `Welcome to our Javascript Pizzeria. Ready to Start? - Click 'OK' to begin.` );
   let username = prompt(`What is your username?`);
   if(username === ""){ alert(`You need to input a username! Try Again.`); pizzaStart(); }
   if(username === null){ alert(`Okay, lets start over!`); pizzaStart(); }
   else{alert(`Hello ${username}! Let's get started!`);}


   const foodChoice = (choice) =>
   {
      if(choice === 0)
      {
         const selectMenu = prompt(
         `Select from the menu: 
         1 - Pizza 
         2 - Pasta 
         3 - Salad 
         Please enter the number of your choice.` );

         if      (selectMenu === "1") { selectedMenu = "Pizza"; choice = 1;}
         else if (selectMenu === "2") { selectedMenu = "Pasta"; choice = 1;}
         else if (selectMenu === "3") { selectedMenu = "Salad"; choice = 1;}
         else if (selectMenu > 3) { alert(`You need to choose a valid item.`); choice = 0; foodChoice(0);}
         else if (selectMenu === "") { alert(`You need to choose a item.`); choice = 0; foodChoice(0);}
         else if (selectMenu === null) { alert(`Okay, let's start over!`); pizzaStart(); }
      
         if(choice === 1)
         {
            alert(`You chose ${selectedMenu}.`);
            return 1;
         }
      }     
   }
   foodChoice(0);

   // Step 3 - Subtype choice
   const subChoice = () => 
   {
      switch (selectedMenu) 
      {
         case "Pizza":
            subGenre = prompt(
            `Select a pizza:
            1 - Funghi
            2 - Calzone
            3 - Vegetariana
            Please enter the number of your choice.`);

            subGenreNames = ["Funghi", "Calzone", "Vegetariana"];
         break;

         case "Pasta":
            subGenre = prompt(
            `Select a pasta:
            1 - Vegan pasta
            2 - Bacon pasta
            3 - Chicken pasta
            Please enter the number of your choice.`);
         
            subGenreNames = ["Vegan pasta", "Bacon pasta", "Chicken pasta"];
         break;

         case "Salad":
            subGenre = prompt(
            `Select a salad:
            1 - Ceasar salad
            2 - Vegan salad
            3 - Fetacheese salad
            Please enter the number of your choice.`);
         
            subGenreNames = ["Ceasar salad", "Vegan salad", "Fetacheese salad"];
         break;
      }

      if      (subGenre === "1") { alert(`You chose ${subGenreNames[0]}.`) }
      else if (subGenre === "2") { alert(`You chose ${subGenreNames[1]}.`) }
      else if (subGenre === "3") { alert(`You chose ${subGenreNames[2]}.`) }
      else if (subGenre > 3) { alert(`You need to choose a valid item.`); subChoice();}
      else if (subGenre === "") { alert(`You need to choose a item.`); subChoice();}
      else if (subGenre === null) { alert(`Okay, let's start over!`); pizzaStart(); }
      else { alert(`Something went wrong! Try Again:)`); }
   }
   subChoice();

   // Step 4 - Age
   const ageChoice = () =>
   {
      const age = prompt(`Type your age for pricing:`);

      if (age <= 17 && age > 0) {
         alert(`You get the kids price!`);
         adultKids = "Tiny Size";
      }
      else if (age >= 18 ) {
         alert(`You will pay the adult price!`);
         adultKids = "Big Boy Size";
      }
      else if(age === ""){ alert(`You need to enter your age!`); ageChoice(); }
      else if(age === null){ alert(`Okay, let's start over!`); pizzaStart(); }
   }
   ageChoice();

   // Step 5 - Order confirmation
   if (subGenre === "1") {
     alert(`Thank you ${username} for your order! You chose ${subGenreNames[0]} in ${adultKids}.`);
   }
   else if (subGenre === "2") {
      alert(`Thank you ${username} for your order! You chose ${subGenreNames[1]} in ${adultKids}.`);
   }
   else if (subGenre === "3") {
     alert(`Thank you ${username} for your order! You chose ${subGenreNames[2]} in ${adultKids}.`);
   }
};


pizzaStart();




// Problems! This code would be easier if I knew some way to let the [] be something like [$]. So the variable would pick the number automaticly?



// const summary = alert(`Thank you ${username} for your order! You chose ${subGenreNames} in ${adultKids}.`);