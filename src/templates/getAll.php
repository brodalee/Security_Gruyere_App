<html lang="en">
<head>
    <meta charset="utf-8">
    <title>TheHottestReviews</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
          integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/public?type=css&resource_name=all">
    <style>
        .fixedElement {
            position:fixed;
            top:0;
            width:100%;
            z-index:100;
        }
    </style>
    <script>
    (function(){
        let _old = window.alert
        window.alert = string => {
            fetch('/api/success/add', {
                method: 'POST',
                body: JSON.stringify({
                    name: 'XSS'   
                })
            })
            .then( _ => {
                _old(string)
            })
            .catch( _ => {
                _old(string)
            })
        }
    })()
</script>
</head>
</html>

<body>

<header class="fixedElement">
    <nav _ngcontent-c1="">
        <div _ngcontent-c1="" class="left-nav">
            <ul _ngcontent-c1="">
                <li _ngcontent-c1="">
                    <a _ngcontent-c1="" href="/" class="active"> Toute les sauces </a>
                </li>
                <li _ngcontent-c1="">
                    <a _ngcontent-c1="" href="/sauces/create"> Ajouter une sauce </a>
                </li>
            </ul>
        </div>
        <div _ngcontent-c1="" class="logo">
            <div _ngcontent-c1="" class="logo-image">
                <svg style="height: 200px; width: 200px;" version="1.0" xmlns="http://www.w3.org/2000/svg"
                     width="159.000000pt" height="318.000000pt" viewBox="0 0 159.000000 318.000000"
                     preserveAspectRatio="xMidYMid meet">

                    <g transform="translate(0.000000,318.000000) scale(0.100000,-0.100000)"
                       fill="#000000" stroke="none">
                        <path d="M782 3127 c16 -65 13 -252 -5 -347 -9 -47 -41 -157 -71 -245 -123
-362 -125 -470 -16 -890 36 -139 42 -175 43 -270 0 -81 -4 -123 -17 -158 -21
-59 -90 -134 -134 -146 -29 -9 -37 -6 -66 20 -59 51 -80 116 -84 260 -2 71 1
142 7 164 6 21 9 40 7 42 -6 6 -43 -125 -55 -191 -15 -84 -13 -258 4 -341 18
-86 80 -213 136 -280 119 -143 173 -250 173 -348 1 -63 -1 -71 -27 -93 -16
-13 -41 -24 -57 -24 -36 0 -92 47 -132 109 -32 51 -34 43 -13 -47 50 -212 236
-372 385 -332 73 20 187 145 256 282 62 123 86 225 91 388 7 193 -17 315 -105
548 -37 98 -52 119 -26 37 21 -65 31 -315 15 -371 -25 -93 -86 -139 -131 -99
-26 23 -31 60 -21 125 6 30 17 98 25 150 9 55 16 156 16 241 0 188 -15 248
-118 466 -106 224 -113 247 -119 378 -4 100 -1 130 37 320 35 173 43 237 47
365 5 139 3 164 -17 238 -23 84 -46 126 -28 49z"/>
                        <path d="M1040 1365 c0 -5 5 -17 10 -25 5 -8 10 -10 10 -5 0 6 -5 17 -10 25
-5 8 -10 11 -10 5z"/>
                    </g>
                </svg>
            </div>
            <div _ngcontent-c1="" class="logo-text">
                <h1 _ngcontent-c1=""> Piquante </h1>
                <h5 _ngcontent-c1=""> La
                    meilleure application de notation de sauces </h5>
            </div>
        </div>
        <div _ngcontent-c1="" class="right-nav">
            <ul _ngcontent-c1="">
                <li _ngcontent-c1=""></li>
                <li _ngcontent-c1=""></li>
                <li _ngcontent-c1="">
                    <a href="/auth/disconnect" _ngcontent-c1=""> Déconnexion </a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<div _ngcontent-c0="" class="container" style="margin-top: 5%">
    <div>
        <p _ngcontent-c5="" class="list-title">THE SAUCES</p>

        <div _ngcontent-c5="" class="sauce-list">
            {{ loop sauces with "./src/templates/sub/sauce.php" }}
        </div>
    </div>
</div>

<div>
    <div id="first_visit" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bienvenue sur Piquante, l'application gruyère</h5>
                    <button onclick="closeModal()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Qu'est-ce que vous allez faire ?</p>
                    <p>Il y a un total de X failles web sur notre application, trouvez-les, exploitez-les et corrigez-les avant qu'un petit malin fasse des dégats.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const closeModal = () => document.getElementById('first_visit').style.display = "none";

    if (localStorage.getItem('first_visit') == null) {
        document.getElementById('first_visit').style.display = "block";
        localStorage.setItem('first_visit', true)
    }
</script>

</body>