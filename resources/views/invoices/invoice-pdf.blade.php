<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <strong style="font-size: 24px">FAKTURA 21000091</strong>
        </div>
        <div class="card-body">
            <div class="row mb-4" style="margin-left: 5px;">
                <div class="col-sm-2" style="padding: 10px">
                    <h6 class="mb-3">Dodávateľ:</h6>
                    <div>
                        <strong>Lýdia Obrtáčová</strong>
                    </div>
                    <div>Prte 557</div>
                    <div>027 32 Zuberec</div>
                    <div>Slovensko</div>
                    <br>
                    <div>IČO: 37672321</div>
                    <div>DIČ: 1042909230</div>
                    <div>Nie je platieľ DPH</div>

                </div>
                <div class="col-sm-4  border-right">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div>Telefón: +421 910 987 849</div>
                    <div>E-mail: obchod@lydusa.sk</div>
                    <div>Vystavil: Lýdia Obrtáčová</div>
                </div>
                <div class="col-sm-1">
                </div>

                <div class="col-sm-5" style="padding: 10px; ">
                    <h6 class="mb-3">Odberateľ:</h6>
                    <div>
                        <strong> Peter mrkva </strong>
                    </div>
                    <div>Ulica: Prte 557</div>
                    <div>Mesto: 02732 Zuberec</div>
                    <div>Email: marek@daniel.com</div>
                    <div>Tel: 0910987654</div>
                </div>
            </div>

            <div class="table-responsive-sm">
                <table class="table table-borderless card-header">
                    <thead>
                        <tr>
                            <th class="left">IBAN</th>
                            <th class="center">SWIFT</th>
                            <th class="right">VS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="left">{{ setting('banka.IBAN_NA_FAKTURU') }}</td>
                            <td class="center">{{ setting('banka.SWIFT_NA_FAKTURU') }}</td>
                            <td class="right">21000091</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <div class="row mb-4" style="margin-left: 5px;">
                <div class="col-sm-6" style="padding: 10px; ">
                    <b>Dátum vystavenia:</b> 01.10.2020 <br>
                        <b>Dátum dodania:</b>    01.10.2020    <br>
                            <b>Dátum splatnosti:</b>  01.10.2020
                </div>
                <div class="col-sm-6" style="padding: 10px; ">
                    <b>Spôsob úhrady:</b>  Dobierka / Platobná brána (online)<br>
                        <b>Spôsob dopravy:</b> Slovenská pošta
                </div>
            </div>

            <div class="table-responsive-sm">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="center">#</th>
                        <th>Item</th>
                        <th>Description</th>

                        <th class="right">Unit Cost</th>
                        <th class="center">Qty</th>
                        <th class="right">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="center">1</td>
                        <td class="left strong">Origin License</td>
                        <td class="left">Extended License</td>

                        <td class="right">$999,00</td>
                        <td class="center">1</td>
                        <td class="right">$999,00</td>
                    </tr>
                    <tr>
                        <td class="center">2</td>
                        <td class="left">Custom Services</td>
                        <td class="left">Instalation and Customization (cost per hour)</td>

                        <td class="right">$150,00</td>
                        <td class="center">20</td>
                        <td class="right">$3.000,00</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-5">

                </div>

                <div class="col-lg-4 col-sm-5 ml-auto">
                    <table class="table table-clear">
                        <tbody>
                        <tr>
                            <td class="left">
                                <strong>Subtotal</strong>
                            </td>
                            <td class="right">$8.497,00</td>
                        </tr>
                        <tr>
                            <td class="left">
                                <strong>Discount (20%)</strong>
                            </td>
                            <td class="right">$1,699,40</td>
                        </tr>
                        <tr>
                            <td class="left">
                                <strong>VAT (10%)</strong>
                            </td>
                            <td class="right">$679,76</td>
                        </tr>
                        <tr>
                            <td class="left">
                                <strong>Total</strong>
                            </td>
                            <td class="right">
                                <strong>$7.477,36</strong>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <hr>
            <div style="font-size: 20px; margin-left: 50px">
                <b>Neplaťte, uhradené na účet.</b>
            </div>
            <br>
            <br>
            <div>
                <img src="" style="height: 170px; margin-left: 90px;">
                <p style="border-top: 2px solid black; font-size: 18px; width: 30%;margin-left: 50px;text-align: center; padding: 3px">Pečiatka a podpis</p>
            </div>

        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
