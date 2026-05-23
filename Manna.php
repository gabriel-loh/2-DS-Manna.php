```php
<?php

// ================================
// CAPTURA DOS DADOS
// ================================
$inputA = isset($_POST['inputA']) ? (int)$_POST['inputA'] : 0;
$inputB = isset($_POST['inputB']) ? (int)$_POST['inputB'] : 0;
$porta  = isset($_POST['porta']) ? $_POST['porta'] : 'AND';

// Ignora B na porta NOT
if ($porta == 'NOT') {
    $inputB = 0;
}

// ================================
// PROCESSAMENTO DAS PORTAS
// ================================
switch ($porta) {

    case 'AND':
        $resultado = ($inputA && $inputB);
        break;

    case 'OR':
        $resultado = ($inputA || $inputB);
        break;

    case 'XOR':
        $resultado = ($inputA != $inputB);
        break;

    case 'NOT':
        $resultado = !$inputA;
        break;

    default:
        $resultado = 0;
}

$statusResultado = $resultado ? 1 : 0;
$fogueteVoando = $statusResultado ? 'voando' : '';


// ================================
// TABELAS VERDADE
// ================================
$tabelas = array(

    'AND' => array(
        array(0,0,0),
        array(0,1,0),
        array(1,0,0),
        array(1,1,1),
    ),

    'OR' => array(
        array(0,0,0),
        array(0,1,1),
        array(1,0,1),
        array(1,1,1),
    ),

    'XOR' => array(
        array(0,0,0),
        array(0,1,1),
        array(1,0,1),
        array(1,1,0),
    ),

    'NOT' => array(
        array(0,1),
        array(1,0),
    )
);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manna Space Mission</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:radial-gradient(circle at center,#0d1b2a 0%,#010811 100%);
    color:white;
    min-height:100vh;
    overflow-x:hidden;
}

/* FUNDO */

.espaco-fundo{
    position:fixed;
    width:100%;
    height:100%;
    z-index:0;
    overflow:hidden;
}

.estrela{
    position:absolute;
    background:white;
    border-radius:50%;
    animation:pulsar 3s infinite;
}

@keyframes pulsar{

    0%,100%{
        opacity:0.3;
        transform:scale(0.8);
    }

    50%{
        opacity:1;
        transform:scale(1.3);
    }
}

.planeta{
    position:absolute;
    border-radius:50%;
}

.marte{
    width:90px;
    height:90px;
    top:10%;
    right:10%;
    background:radial-gradient(circle,#ff6b35,#702632);
    box-shadow:0 0 30px rgba(255,100,50,.5);
}

.netuno{
    width:140px;
    height:140px;
    bottom:5%;
    left:5%;
    background:radial-gradient(circle,#4ea8de,#1d3557);
    box-shadow:0 0 40px rgba(78,168,222,.4);
}

/* LAYOUT */

.container{
    position:relative;
    z-index:2;
    display:flex;
    min-height:100vh;
}

.esquerda{
    width:420px;
    background:rgba(0,0,0,.4);
    backdrop-filter:blur(10px);
    padding:35px;
}

.direita{
    flex:1;
    position:relative;
    display:flex;
    justify-content:center;
    align-items:flex-end;
    padding-bottom:80px;
}

/* PAINEL */

.painel{
    background:rgba(255,255,255,.03);
    border:1px solid rgba(0,242,254,.2);
    border-radius:25px;
    padding:30px;
    box-shadow:0 10px 30px rgba(0,0,0,.5);
}

h1{
    text-align:center;
    margin-bottom:30px;
    color:#00f2fe;
    letter-spacing:3px;
}

/* FORM */

.config{
    display:flex;
    flex-direction:column;
    gap:20px;
}

label{
    color:#94a3b8;
    margin-bottom:5px;
    display:block;
    text-transform:uppercase;
    font-size:.8rem;
}

select{
    width:100%;
    padding:12px;
    border-radius:10px;
    border:none;
    background:#111e31;
    color:white;
    font-size:1rem;
    border:1px solid #334155;
}

select:hover{
    border-color:#00f2fe;
}

/* PORTA */

.display-porta{
    margin:35px auto;
    width:180px;
    height:100px;
    position:relative;
}

.gate-shape{
    width:90px;
    height:60px;
    border:3px solid #00f2fe;
    position:absolute;
    left:45px;
    top:20px;
    background:rgba(0,242,254,.05);
}

.gate-AND{
    border-top-right-radius:50px;
    border-bottom-right-radius:50px;
}

.gate-OR{
    border-radius:0 50px 50px 0;
    border-left:none;
}

.gate-XOR{
    border-radius:0 50px 50px 0;
    border-left:none;
}

.gate-NOT{
    width:0;
    height:0;
    border-top:30px solid transparent;
    border-bottom:30px solid transparent;
    border-left:70px solid rgba(0,242,254,.2);
    background:none;
    border-right:none;
}

/* RESULTADO */

.resultado{
    margin-top:20px;
    padding:15px;
    border-radius:12px;
    text-align:center;
    font-size:1.1rem;
    font-weight:bold;

    background:
    <?php
    echo $statusResultado
    ? 'rgba(46,204,113,.2)'
    : 'rgba(231,76,60,.2)';
    ?>;

    border:1px solid
    <?php
    echo $statusResultado
    ? '#2ecc71'
    : '#e74c3c';
    ?>;

    color:
    <?php
    echo $statusResultado
    ? '#2ecc71'
    : '#e74c3c';
    ?>;
}

/* FOGUETE */

.foguete-container{
    position:relative;
    width:90px;
    transition:transform 2s ease;
}

.foguete-container.voando{
    transform:translateY(-70vh);
}

.foguete-corpo{
    width:90px;
    height:140px;
    background:linear-gradient(to right,#fff,#ddd);
    border-radius:50% 50% 15% 15%;
    border:2px solid #333;
    position:relative;
}

.bico{
    position:absolute;
    top:-30px;
    width:90px;
    height:40px;
    background:#e63946;
    border-radius:50% 50% 0 0;
    border:2px solid #333;
}

.janela{
    width:25px;
    height:25px;
    border-radius:50%;
    background:#00f2fe;
    margin:30px auto 10px;
    border:2px solid #222;
}

.marca{
    text-align:center;
    color:#111;
    font-weight:900;
}

.asa-esquerda,
.asa-direita{
    position:absolute;
    width:25px;
    height:50px;
    background:#e63946;
    bottom:15px;
}

.asa-esquerda{
    left:-22px;
    border-radius:20px 0 0 20px;
}

.asa-direita{
    right:-22px;
    border-radius:0 20px 20px 0;
}

.propulsor{
    width:30px;
    height:12px;
    background:#555;
    margin:auto;
}

.fogo{
    width:25px;
    height:70px;
    margin:auto;
    opacity:0;
    transition:.3s;
    background:linear-gradient(to bottom,#ffff00,#ff6600,transparent);
    border-radius:0 0 50% 50%;
    animation:queimar .15s infinite alternate;
}

.voando .fogo{
    opacity:1;
}

@keyframes queimar{

    from{
        transform:scaleY(.9);
    }

    to{
        transform:scaleY(1.2);
    }
}

/* TABELA */

.tabela-container{
    margin-top:35px;
}

.tabela-titulo{
    text-align:center;
    margin-bottom:15px;
    color:#00f2fe;
    font-size:1rem;
    letter-spacing:2px;
}

table{
    width:100%;
    border-collapse:collapse;
    overflow:hidden;
    border-radius:15px;
}

th{
    background:#00b4d8;
    color:#fff;
    padding:12px;
}

td{
    padding:12px;
    text-align:center;
    background:rgba(255,255,255,.04);
    border-bottom:1px solid rgba(255,255,255,.08);
}

tr:hover td{
    background:rgba(0,242,254,.08);
}

.saida-1{
    color:#2ecc71;
    font-weight:bold;
}

.saida-0{
    color:#e74c3c;
    font-weight:bold;
}

</style>

</head>

<body>

<div class="espaco-fundo">

    <div class="planeta marte"></div>
    <div class="planeta netuno"></div>

    <?php

    for($i=0;$i<60;$i++){

        $top = rand(0,100);
        $left = rand(0,100);
        $size = rand(1,3);

        echo '<div class="estrela"
        style="
        top:'.$top.'%;
        left:'.$left.'%;
        width:'.$size.'px;
        height:'.$size.'px;
        animation-delay:'.(rand(0,20)/10).'s;
        "></div>';
    }

    ?>

</div>

<div class="container">

    <div class="esquerda">

        <div class="painel">

            <h1>MANNA MISSION</h1>

            <form method="POST">

                <div class="config">

                    <div>

                        <label>INPUT A</label>

                        <select name="inputA" onchange="this.form.submit()">

                            <option value="0"
                            <?php echo ($inputA == 0 ? 'selected' : ''); ?>>
                            0 LOW
                            </option>

                            <option value="1"
                            <?php echo ($inputA == 1 ? 'selected' : ''); ?>>
                            1 HIGH
                            </option>

                        </select>

                    </div>

                    <div>

                        <label>PORTA</label>

                        <select name="porta" onchange="this.form.submit()">

                            <option value="AND"
                            <?php echo ($porta == 'AND' ? 'selected' : ''); ?>>
                            AND
                            </option>

                            <option value="OR"
                            <?php echo ($porta == 'OR' ? 'selected' : ''); ?>>
                            OR
                            </option>

                            <option value="XOR"
                            <?php echo ($porta == 'XOR' ? 'selected' : ''); ?>>
                            XOR
                            </option>

                            <option value="NOT"
                            <?php echo ($porta == 'NOT' ? 'selected' : ''); ?>>
                            NOT
                            </option>

                        </select>

                    </div>

                    <div
                    style="<?php echo ($porta == 'NOT'
                    ? 'opacity:.3;pointer-events:none;'
                    : ''); ?>">

                        <label>INPUT B</label>

                        <select name="inputB" onchange="this.form.submit()">

                            <option value="0"
                            <?php echo ($inputB == 0 ? 'selected' : ''); ?>>
                            0 LOW
                            </option>

                            <option value="1"
                            <?php echo ($inputB == 1 ? 'selected' : ''); ?>>
                            1 HIGH
                            </option>

                        </select>

                    </div>

                </div>

            </form>

            <!-- PORTA -->

            <div class="display-porta">

                <div class="gate-shape gate-<?php echo $porta; ?>"></div>

            </div>

            <!-- RESULTADO -->

            <div class="resultado">

                OUTPUT:
                <?php echo $statusResultado; ?>

                <br><br>

                <?php

                if($statusResultado){
                    echo '🚀 IGNIÇÃO DETECTADA';
                }else{
                    echo '🛰️ SISTEMA EM AGUARDO';
                }

                ?>

            </div>

            <!-- TABELA -->

            <div class="tabela-container">

                <div class="tabela-titulo">
                    TABELA VERDADE <?php echo $porta; ?>
                </div>

                <table>

                    <thead>

                        <tr>

                            <th>A</th>

                            <?php
                            if($porta != 'NOT'){
                                echo '<th>B</th>';
                            }
                            ?>

                            <th>SAÍDA</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php

                    foreach($tabelas[$porta] as $linha){

                        echo '<tr>';

                        echo '<td>'.$linha[0].'</td>';

                        if($porta != 'NOT'){

                            echo '<td>'.$linha[1].'</td>';

                            $classe = $linha[2] ? 'saida-1' : 'saida-0';

                            echo '<td class="'.$classe.'">'.$linha[2].'</td>';

                        }else{

                            $classe = $linha[1] ? 'saida-1' : 'saida-0';

                            echo '<td class="'.$classe.'">'.$linha[1].'</td>';
                        }

                        echo '</tr>';
                    }

                    ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- DIREITA -->

    <div class="direita">

        <div class="foguete-container <?php echo $fogueteVoando; ?>">

            <div class="bico"></div>

            <div class="asa-esquerda"></div>

            <div class="asa-direita"></div>

            <div class="foguete-corpo">

                <div class="janela"></div>

                <div class="marca">
                    MANNA
                </div>

            </div>

            <div class="propulsor"></div>

            <div class="fogo"></div>

        </div>

    </div>

</div>

</body>
</html>
```
