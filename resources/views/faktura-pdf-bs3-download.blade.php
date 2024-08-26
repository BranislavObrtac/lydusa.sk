<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
{{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">--}}
<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <title>Faktúra</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8pt;
            max-width: 900px;
            height: 1260px;
        }
    </style>
</head>
<body  class="login-page" style="background: white">
<div>
    <div class="row">
        <div class="col-xs-9">
            <strong  style="font-size: 24px">Faktúra {{ numberOfInvoice($created_at,$id) }}</strong>
        </div>
        <div class="col-xs-2">
            <strong  style="font-size: 24px">Lydusa</strong>
        </div>
    </div> {{--Header--}}

    <div class="row" style="margin-top: 15px;">
        <div class="col-xs-6">
            <p style="font-size: 10pt;">DODÁVATEĽ</p>

        </div>
    </div>

    <div class="row">
        <div class="col-xs-2">
            <strong >Lýdia Obrtáčová</strong><br>
            Prte 557 <br>
            027 32 Zuberec <br>
            Slovensko <br>
            <br>
            IČO: 37672321 <br>
            DIČ: 1042909230 <br>
            Nie je platieľ DPH <br>
        </div>
        <div class="col-xs-3" style="margin-top: 2px; border-right: 1px solid gray">
            <br><br><br><br><br><br>
            Telefón: +421 910 987 849 <br>
            E-mail: obchod@lydusa.sk <br>
            Vystavil: Lýdia Obrtáčová
        </div>
        <div class="col-xs-1">
        </div>

        <div class="col-xs-5" style="margin-top: -37px">
            <p style="font-size: 10pt;">ODBERATEĽ</p>
            <strong>{{ $first_name }} {{ $second_name }}</strong> <br>
            Ulica: {{ $address }} <br>
            Mesto: {{ $postalcode }} {{ $city }} <br>
            Email: {{ $email }}<br>
            Tel: {{ $phone }} <br>
        </div>
    </div> {{--Predajca/Kupujúci--}}

    <div class="row" style="margin-top: 5px"> <!--živnostenský register-->
        <div class="col-xs-6">
            <p style="font-size: 7pt; text-decoration: underline"> Zapísaná v ŽR ObÚ Námestovo, č. živnostenského registra 510-4360. </p>
        </div>
        <div class="col-xs-4">

        </div>
    </div>


    <table class="table" style="margin-top: 10px; max-width: 73%; background-color: lightgrey">
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
                    <td class="right">Faktúra {{ numberOfInvoice($created_at,$id) }}</td>
                </tr>
                </tbody>
            </table> {{--Banka--}}

    <div class="row" style="margin-top: -10px;">
        <div class="col-xs-2">
            <b>Dátum vystavenia:</b> <br>
            <b>Dátum dodania:</b> <br>
            <b>Dátum splatnosti:</b>
        </div>
        <div class="col-xs-2">
            {{ presentDateInvoice($created_at) }} <br>
            {{ presentDateInvoice($created_at) }} <br>
            @if ($payment_optn == 'Dobierka')
                Dobierka
            @else
                {{ presentDateInvoice($created_at) }}
            @endif

        </div>
        <div class="col-xs-2">
            <b>Spôsob úhrady:</b> <br>
            <b>Spôsob dopravy:</b>
        </div>
        <div class="col-xs-4">
            {{ $payment_optn }}<br>
            Slovenská pošta
        </div>
    </div> {{--Doprava/Platba--}}

    <div class="table-responsive-sm" style="margin-top: 10px;">
                <table class="table table-striped" style="max-width: 73%; background-color: lightgrey">
                    <thead>
                    <tr>
                        <th class="center">#</th>
                        <th>Produkt</th>
                        <th>Popis</th>

                        <th class="right">Cena za KS</th>
                        <th class="center">Počet</th>
                        <th class="right">Spolu</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td class="center">{{ $loop->index + 1 }}</td>
                            <td class="left strong">{{ $product->product_name }}</td>
                            <td class="left">Veľkosť: {{ $product->product_size }}</td>

                            <td class="right" style="font-family: Roboto, Arial, sans-serif !important; font-size: 9pt">{{ round($product->product_price,2) }}€</td>
                            <td class="center" style="font-family: Roboto, Arial, sans-serif !important; font-size: 9pt">{{ $product->pivot->quantity }}</td>
                            <td class="right" style="font-family: Roboto, Arial, sans-serif !important; font-size: 9pt">{{ round(($product->product_price)*($product->pivot->quantity),2) }}€</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div> {{--Tabulka produktov--}}

    <div class="row">
                <div class="col-xs-7">
                    @if ($payment_optn != 'Dobierka')
                        <p style="margin-top: 40px; font-size: 16pt;">Neplaťte, uhradené na účet.</p>
                    @endif
                </div>
                <div class="col-xs-2">
                    <b>Doprava</b> <br>
                    <b>Platba</b> <br>
                    <b>Celková suma</b>
                </div>
                <div class="col-xs-2" style="font-family: Roboto, Arial, sans-serif !important; font-size: 10pt">
                    {{ $delivery_price }} <br>
                    {{ $payment_price }} <br>
                    <b>{{ $total }}</b>
                </div>
            </div> {{--Zhrnutie objednávky--}}

    <div class="row" style="margin-top: 70px;">
        <div class="col-xs-4">
            <?php $image_path = '/storage/peciatka/peciatka.jpg'; ?>
            <img src="{{ public_path() . $image_path }}" style="height: 85px; margin-left: 40px; rotation: 15deg">
            <p style="border-top: 1px solid gray; font-size: 10pt; width: 100%;text-align: center; padding: 3px">
                Pečiatka a podpis
            </p>
        </div>
    </div>

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
</body>
</html>
