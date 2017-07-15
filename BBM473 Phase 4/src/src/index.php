<!DOCTYYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/semantic.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-serialize-object/2.5.0/jquery.serialize-object.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/semantic.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script>
</head>
<body>

<div class="ui container" style="padding: 50px;">
    <div class="ui column centered padded grid container">
        <div class="seven wide column">
            <div class="ui blue segment">
                <h1 class="ui header" style="text-align: center">Login</h1>
                <form id="login-form" class="ui form" action="login.php" method="post">
                    <div class="field">
                        <label class="left aligned">Username</label>
                        <input type="text" name="username" placeholder="Username">
                    </div>
                    <div class="field">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Password">
                    </div>
                    <div style="text-align: center">
                        <button id="submit-button" class="ui blue button" onclick="loginForm()">Login</button>
                        <button type="button" class="ui blue basic button" onclick="createAccountModal()">Register
                        </button>
                        <!--<a class="ui blue basic button" href="register.php">Register</a>-->
                    </div>
                </form>

            </div>

            <div id="login-error" class="ui negative message" style="display: none">
                <i class="close icon" onclick="hideErrorMessage()"></i>
                <div class="header">
                    Login Failed!
                </div>
                <p id="error-message"></p>
            </div>
        </div>
    </div>

    <div class="ui modal">
        <i class="close icon"></i>
        <div class="header">
            Create An Account
        </div>
        <div class="ui text container" style="padding: 50px; size: 200px;">
            <h1 class="ui header" style="text-align: center">Personal Information</h1>
            <form id="personal-info-form" action="register.php" method="post" class="ui form">
                <div class="field">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Username">
                </div>
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Password">
                </div>
                <div class="field">
                    <label>First Name</label>
                    <input type="text" name="first-name" placeholder="First Name">
                </div>
                <div class="field">
                    <label>Last Name</label>
                    <input type="text" name="last-name" placeholder="Last Name">
                </div>
                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Email">
                </div>
            </form>

            <form id="shipping-info-form" class="ui form">
                <h1 class="ui header" style="text-align: center">Shipping Information</h1>
                <div class="field">
                    <label>Name</label>
                    <div class="two fields">
                        <div class="field">
                            <input type="text" name="shipping[first-name]" placeholder="First Name">
                        </div>
                        <div class="field">
                            <input type="text" name="shipping[last-name]" placeholder="Last Name">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label>Billing Address</label>
                    <div class="fields">
                        <div class="twelve wide field">
                            <input type="text" name="shipping[address]" placeholder="Street Address">
                        </div>
                        <div class="four wide field">
                            <input type="text" name="shipping[address-2]" placeholder="Apt #">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label>State</label>
                    <div class="two fields">
                        <div class="field">
                            <input type="text" name="state" placeholder="State">
                        </div>
                        <div class="field">
                            <input type="text" name="country" placeholder="Country">
                        </div>
                    </div>
                </div>
                <h4 class="ui dividing header">Billing Information</h4>
                <div class="field">
                    <label>Card Type</label>
                    <div class="ui selection dropdown">
                        <input type="hidden" name="card[type]">
                        <div class="default text">Type</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="visa">
                                <i class="visa icon"></i>
                                Visa
                            </div>
                            <div class="item" data-value="amex">
                                <i class="amex icon"></i>
                                American Express
                            </div>
                            <div class="item" data-value="discover">
                                <i class="discover icon"></i>
                                Discover
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fields">
                    <div class="seven wide field">
                        <label>Card Number</label>
                        <input type="text" name="card[number]" maxlength="16" placeholder="Card #">
                    </div>
                    <div class="three wide field">
                        <label>CVC</label>
                        <input type="text" name="card[cvc]" maxlength="3" placeholder="CVC">
                    </div>
                    <div class="six wide field">
                        <label>Expiration</label>
                        <div class="two fields">
                            <div class="field">
                                <select class="ui fluid search dropdown" name="card[expire-month]">
                                    <option value="">Month</option>
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            <div class="field">
                                <input type="text" name="card[expire-year]" maxlength="4" placeholder="Year">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="ui checkbox">
                        <input type="checkbox" tabindex="0" class="hidden">
                        <label>I agree to the Terms and Conditions</label>
                    </div>
                </div>

            </form>
        </div>
        <div class="actions">
            <div style="text-align: center">
                <input type="submit" id="create-account" class="ui blue button" value="Create Your Account"/>
            </div>
        </div>
    </div>
</div>

<script src="jsutils.js"></script>

<?php


?>
</body>
</html>
