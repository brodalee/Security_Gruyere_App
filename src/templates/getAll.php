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
            .then( async _ => {
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

{{ use::menu.html }}

<div _ngcontent-c0="" class="container" style="margin-top: 5%">
    <div>
        <p _ngcontent-c5="" class="list-title">THE SAUCES</p>

        <div _ngcontent-c5="" class="sauce-list">
            {{ loop sauces with "./src/templates/sub/sauce.php" }}
        </div>
    </div>
</div>

{{ use::flash_file.html }}

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
                    <p>Il y a un total de {{ count }} failles web sur notre application, trouvez-les, exploitez-les et corrigez-les avant qu'un petit malin fasse des dégats.</p>
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

<script>
    (() => {
        for (let c of document.getElementById("flashes").children) {
            if (c.innerHTML.trim() == "" || c.innerHTML.trim() == " ") c.remove()
        }
    })()

</script>
</body>