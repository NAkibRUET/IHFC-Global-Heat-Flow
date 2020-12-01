function YearFilterHandling() {
  //console.log("addad");
  var x = document.getElementById("select_year").value;
  //console.log(x);
  //document.getElementById("demo").innerHTML = "You selected: " + x;
  $.ajax({
    method: "GET",
    url: "./getSiteName.php",
    dataType: "json",
    success: function (response) {
      console.log(response);
    },
    error: (error) => {
      console.log(JSON.stringify(error));
    },
  });
}
