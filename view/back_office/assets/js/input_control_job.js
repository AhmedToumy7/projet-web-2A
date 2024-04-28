document.querySelector("#jobform").addEventListener("submit", function (event) {
  const titlePattern = /^[a-zA-Z0-9\s]{1,30}$/;
  const locationPattern = /^[a-zA-Z0-9\s]{1,30}$/;
  const salaryPattern = /^[0-9,]+(\$|TND)$/;
  const descriptionPattern =
    /^[a-zA-Z0-9\s,;:!?@#$%&*()-+=\[\]{}|<>.\'\"]{1,1000}$/;
  const companyPattern = /^[a-zA-Z0-9\s]{1,30}$/;

  var titleInput = document.querySelector("#title");
  var locationInput = document.querySelector("#location");
  var salaryInput = document.querySelector("#salary");
  var descriptionInput = document.querySelector("#description");
  var companyInput = document.querySelector("#company");

  // Remove any existing error messages
  document.querySelectorAll(".error-message").forEach(function (item) {
    item.remove();
  });

  if (!titlePattern.test(titleInput.value)) {
    event.preventDefault();
    displayError(
      "Invalid title. Please make sure your title is 1-30 characters long and does not contain any special characters.",
      titleInput
    );
  }

  if (!locationPattern.test(locationInput.value)) {
    event.preventDefault();
    displayError(
      "Invalid location. Please make sure your location is 1-30 characters long and does not contain any special characters.",
      locationInput
    );
  }

  if (!salaryPattern.test(salaryInput.value)) {
    event.preventDefault();
    displayError(
      "Invalid salary. Please make sure your salary is in the correct format (numbers followed by $ or TND).",
      salaryInput
    );
  }

  if (descriptionInput && !descriptionPattern.test(descriptionInput.value)) {
    event.preventDefault();
    displayError(
      "Invalid description. Please make sure your description is 1-1000 characters long.",
      descriptionInput
    );
  }

  if (companyInput && !companyPattern.test(companyInput.value)) {
    event.preventDefault();
    displayError(
      "Invalid company name. Please make sure your company name is 1-30 characters long and does not contain any special characters.",
      companyInput
    );
  }
});
//TODO fix this php instead of js
document
  .querySelector("#fieldform")
  .addEventListener("submit", function (event) {
    const idPattern = /^[0-9]{1,3}$/;
    const fieldNamePattern = /^[a-zA-Z]{1,20}$/;
    const descriptionPattern = /^.{1,60}$/;

    var idInput = document.querySelector("#inputID");
    var fieldNameInput = document.querySelector("#inputField");
    var descriptionInput = document.querySelector("#inputDescription");

    // Remove any existing error messages
    document.querySelectorAll(".error-message").forEach(function (item) {
      item.remove();
    });

    if (!idPattern.test(idInput.value)) {
      event.preventDefault();
      displayError(
        "Invalid ID. Please make sure your ID is 1-3 digits long.",
        idInput
      );
    }

    if (!fieldNamePattern.test(fieldNameInput.value)) {
      event.preventDefault();
      displayError(
        "Invalid field name. Please make sure your field name is 1-20 characters long and does not contain any special characters or numbers.",
        fieldNameInput
      );
    }

    if (!descriptionPattern.test(descriptionInput.value)) {
      event.preventDefault();
      displayError(
        "Invalid description. Please make sure your description is 1-60 characters long.",
        descriptionInput
      );
    }
  });

function displayError(message, inputElement) {
  var errorMessage = document.createElement("div");
  errorMessage.className = "error-message";
  errorMessage.style.color = "red";
  errorMessage.textContent = message;
  inputElement.parentNode.insertBefore(errorMessage, inputElement.nextSibling);
}
