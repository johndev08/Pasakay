const pwd = document.getElementById("password");
const chk = document.getElementById("chk");

chk.onchange = function (e) {
    pwd.type = chk.checked ? "text" : "password";
};


function handleImageChange(event) {
    var reader = new FileReader();
    reader.onload = function() {
      var preview = document.getElementById('preview');
      var label = document.getElementById('lbl'); 
      preview.src = reader.result;
      preview.style.display = 'block';
      label.style.display = 'none';
    };
    reader.readAsDataURL(event.target.files[0]);
  }
  document.getElementById('passenger_image').addEventListener('change', handleImageChange);
  document.getElementById('driver_image').addEventListener('change', handleImageChange);

  function goBack() {
    window.history.back();
}


function updateFare() {
  const selectElement = document.getElementById('need_ride');
  const selectedOption = selectElement.options[selectElement.selectedIndex];
  const regularFare = parseFloat(selectedOption.getAttribute('data-fare'));
  const specialFare = parseFloat(selectedOption.getAttribute('data-special-fare'));

  const quantitySelect = document.getElementById('east_quantity');
  const selectedQuantity = quantitySelect.options[quantitySelect.selectedIndex].value;

  let fareToDisplay;

  if (selectedOption.value === "") {
      fareToDisplay = "???";
  } else if (selectedQuantity === 'Special') {
      fareToDisplay = specialFare;
  } else {
      const numberOfPassengers = parseInt(selectedQuantity.charAt(1));
      fareToDisplay = regularFare * numberOfPassengers;
  }

  document.getElementById('fare_display').value = fareToDisplay === "???" ? fareToDisplay : fareToDisplay.toFixed(2);
}
