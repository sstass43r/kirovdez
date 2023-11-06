  document
    .getElementById("form-zapis")
    .addEventListener("submit", function (event) {
      event.preventDefault();
  
      var form = this;
      var formData = new FormData(form);
  
      fetch("mail.php", {
        method: "POST",
        body: formData,
      })
        .then(function (response) {
          if (response.ok) {
            document.getElementById("success-form").style.display = "block";
            setTimeout(function () {
              document.getElementById("success-form").style.display = "none";
            }, 1000);
          } else {
            document.getElementById("error-form").style.display = "block";
            setTimeout(function () {
              document.getElementById("error-form").style.display = "none";
            }, 1000);
          }
        })
        .catch(function (error) {
          console.error(error);
        });
    });  