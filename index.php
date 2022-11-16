<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <div class="container">
        <br>
        <form action="backend.php" method="post" id="payment-form">
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Name</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email </label>
                <input type="email" id="label1" name="email" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Select Packages</label>
                <select class="form-select" id="demoSelect" name="package" aria-label="Default select example">
                    <!-- <option selected>Select Package</option> -->
                    <option value="500000 Silver">Silver</option>
                    <option value="1000000 Gold">Gold</option>
                    <option value="1500000 Platinum">Platinum</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Enter Ammount</label>
                <input type="text" name="amount" id="demoInput" readonly class="form-control">
            </div>
            <div id="card-element">
            </div>
            <div id="card-errors" role="alert"></div>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
<script type="text/javascript">
    $('#demoSelect').change(function() {

        var p = $('#demoSelect').val();
        var pp= p.split(" ");
        var pp= p.substring(0,7);
        // console.log(pp[pp.length-1]);
        // alert(pp);
        var pp1 = pp/100;
        $('#demoInput').val(pp1);
    });
    var stripe = Stripe("pk_test_51M35IfLsuGyV4cRXL5d9GrGV7UiTCSw84LcVwHXm4aqH3SIJsWtWSqFDMhmltCpzFQZVUpPD8zpEr18fuHNF3rl000AJifjLUl");
    var elements = stripe.elements();
    var style = {
        base: {
            color: "#32325d",
            fontSmoothing: "antialiased",
            fontSize: "16px",
            "::placeholder": {
                color: "#aab7c4"
            }
        },
        invalid: {
            color: "#fa755a",
            iconColor: "#fa755a"
        }
    };
    var card = elements.create("card", {
        style: style
    });
    card.mount("#card-element");
    card.addEventListener("change", function(event) {
        var displayError = document.getElementById("card-errors");
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = "";
        }
    });
    var form = document.getElementById("payment-form");
    form.addEventListener("submit", function(event) {
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
            if (result.error) {

                var errorElement = document.getElementById("card-errors");
                errorElement.textContent = result.error.message;
            } else {

                stripeTokenHandler(result.token);
            }
        });
    });

    function stripeTokenHandler(token) {

        var form = document.getElementById("payment-form");
        var hiddenInput = document.createElement("input");
        hiddenInput.setAttribute("type", "hidden");
        hiddenInput.setAttribute("name", "stripeToken");
        hiddenInput.setAttribute("value", token.id);
        form.appendChild(hiddenInput);
        form.submit();
    }
</script>

</html>