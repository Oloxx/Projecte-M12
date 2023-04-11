<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />
    <!--NavBar-->
    <nav class="navbar navbar-expand-lg colorbg sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img class='linkLogo' id="linkLogo" aria-current="page"
                    src="../../img/logo/Logo_LaboraSQL_White.png" alt="Logo IES Carles Vallbona" width="150"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a href="#adaptabilitat" class="nav-link link-light px-2">Adaptabilitat</a>
                    </li>
                    <li class="nav-item"><a href="#control" class="nav-link link-light px-2">Control</a></li>
                    <li class="nav-item"><a href="#serveis" class="nav-link link-light px-2">Serveis</a></li>
                    <li class="nav-item"><a href="#contacte" class="nav-link link-light px-2">Contacte</a></li>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0" role="search">
                    <li class="nav-item"><a href="/main/main.html" class="nav-link link-light px-2">
                            <Link :href="route('login')"
                                class="font-semibold hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                            Log in</Link>
                        </a></li>
                    <li class="nav-item"><a href="#" class="nav-link link-light px-2"><Link v-if="canRegister" :href="route('register')"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Sign in</Link></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header id="header" class="py-3 border-bottom bg-light" style="display:flex">
        <div class="container-fluid d-flex flex-wrap justify-content-center ">
            <a href="/" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none link-logo"
                aria-current="page">
                <span class="fs-4"><img aria-current="page" src="../../img/logo/Logo_LaboraSQL.png"
                        alt="Logo IES Carles Vallbona" width="300"></span>
            </a>
        </div>
    </header>
    <div class="containerimgdisco">
        <img src="../../img/disco.jpg" class="imgdisco" alt="Imagen de disco">
    </div>
    <!--Introduction-->
    <div class="container-fluid d-flex flex-wrap tittle-container">
        <h2 id="LaboraSQL">QUE FA LABORASQL PER TU</h2>
    </div>
    <div class="container-fluid d-flex flex-wrap container-text">
        <p>La nostra aplicació ha estat dissenyada pensant en la necessitat de les institucions educatives de tenir una
            eina que els permeti gestionar de manera efectiva i eficient la seva col·laboració amb empreses facilitants
            d'oferta de treball en pràctiques pels alumnes.</p>

        <p><b>LaboraSQL</b> ha estat desenvolupada amb l'objectiu de millorar
            el treball administratiu dels docents i facilitar la gestió de les dades de les empreses i els estudiants.
        </p>
    </div>
    <!--Adaptabilitat i compromis-->
    <section class="adaptabilitat-compromis">
        <!--Adaptabilitat-->
        <div class="section-activity">
            <div class="subsection-img">
                <img src="../../img/adaptable.jpg" alt="Piezas de puzzle encajando" />
            </div>
            <div class=" container subsection-text">
                <div class="section-div-text-margins">
                    <h1 id="adaptabilitat">API ADAPTABLE</h1>
                    <h2>
                        Una base de dades relacional adaptable a les necessitats de cada centre
                    </h2>
                    <p>
                        <b>LaboraSQL</b> està pensada per facilitar les tasques administratives dels docents i per
                        adaptar-se a totes les exigencies que un centre pot tenir. Tot i així, des del nostre equip de
                        professionals podem adaptar la aplicació a sol·lucions personalitzades.
                    </p>
                    <button class="subbutton-section">
                        LEARN MORE<span class="arrow"><i class="fa-solid fa-arrow-right-long"></i></span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Compromís -->
        <section class="section-activity">
            <div class="container subsection-text">
                <div class="section-div-text-margins">
                    <h1 id="control">TOT SOTA CONTROL</h1>
                    <h2>
                        Permet fer seguiment de les relacions entre alumnes i empreses
                    </h2>
                    <p>
                    <p><b>LaboraSQL</b> permet centralitzar les dades de forma segura, la qual
                        cosa facilita tenir accés ràpid i fàcil a la informació rellevant de cadascuna d'elles.
                        A més, permet fer un seguiment de les col·laboracions dels alumnes amb aquestes
                        empreses, i establir comentaris i observacions sobre
                        aquestes col·laboracions.</p>
                    </p>
                    <button class="subbutton-section">
                        READ MORE<span class="arrow"><i class="fa-solid fa-arrow-right-long"></i></span>
                    </button>
                </div>
            </div>
            <div class="section-div-video"><video src="../../video/seguimiento.mp4" autoplay loop muted></video></div>
        </section>
    </section>

    <section class="adaptabilitat-compromis-mvl">
        <div class=" container-fluid d-flex flex-wrap tittle-container">
            <h2 id="serveis">API ADAPTABLE</h2>
        </div>
        <div class="container-fluid d-flex flex-wrap tittle-container-h2 bg-primary">
            <h2 id="serveis">Una base de dades relacional adaptable a les necessitats de cada centre</h2>
        </div>
        <div class="container-fluid d-flex flex-wrap container-text">
            <p>
                <b>LaboraSQL</b> està pensada per facilitar les tasques administratives dels docents i per
                adaptar-se a totes les exigencies que un centre pot tenir. Tot i així, des del nostre equip de
                professionals podem adaptar la aplicació a sol·lucions personalitzades.
            </p>
        </div>
        <div class="containerimgdisco">
            <img src="../../img/adaptable.jpg" class="imgdisco" alt="Imagen de disco">
        </div>
        <div class=" container-fluid d-flex flex-wrap tittle-container">
            <h2 id="serveis">TOT SOTA CONTROL</h2>
        </div>
        <div class="container-fluid d-flex flex-wrap tittle-container-h2 bg-primary">
            <h2 id="serveis">Permet fer seguiment de les relacions entre alumnes i empreses</h2>
        </div>
        <div class="container-fluid d-flex flex-wrap container-text">
            <p>
            <p><b>LaboraSQL</b> permet centralitzar les dades de forma segura, la qual
                cosa facilita tenir accés ràpid i fàcil a la informació rellevant de cadascuna d'elles.
                A més, permet fer un seguiment de les col·laboracions dels alumnes amb aquestes
                empreses, i establir comentaris i observacions sobre
                aquestes col·laboracions.</p>
            </p>
        </div>
        <div class="div-video"><video src="../../video/seguimiento.mp4" autoplay loop muted></video></div>

    </section>

    <!--Serveis-->
    <div class=" container-fluid d-flex flex-wrap tittle-container">
        <h2 id="serveis">SERVEIS LABORASQL</h2>
    </div>
    <div class="container-fluid serv-container margin-serveis">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-3 serv">
                <div class="servicio">
                    <img src="../../img/datos.jpg" class="rounded shadow-4-strong float-left" alt="Imagen de 0 y 1"><br><br>
                    <div class="container-fluid titulo-serv">
                        <p><b>EMMAGATZEMATGE DE DADES</b></p>
                    </div>
                    <div class="container-fluid description-prod">
                        <p> Registre i emmagatzematge de les dades de les empreses col·laboradores, com a nom,
                            adreça,
                            número de telèfon, correu electrònic i altres detalls rellevants.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 serv">
                <div class="servicio">
                    <img src="../../img/seguimiento.jpg" class="rounded float-left" alt="..."><br><br>
                    <div class=" container-fluid titulo-serv">
                        <p><b>SEGUIMENT DE COL·LABORACIONS</b></p>
                    </div>
                    <div class="container-fluid description-prod">
                        <p> Registre i seguiment de les col·laboracions dels alumnes amb aquestes empreses,
                            incloent-hi
                            informació sobre l'estada de l'alumne.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 serv">
                <div class="servicio">
                    <img src="../../img/observations.jpg" class="rounded float-left" alt="..."><br><br>
                    <div class="container-fluid titulo-serv">
                        <p><b>AFEGEIX OBSERVACIONS</b></p>
                    </div>
                    <div class="container-fluid description-prod">
                        <p> Possibilitat d'afegir observacions sobre cada col·laboració per facilitar
                            una visió més detallada de l'experiència de l'alumne en l'empresa.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 serv">
                <div class="servicio">
                    <img src="../../img/security.jpg" class="rounded float-left" alt="..."><br><br>
                    <div class="container-fluid titulo-serv">
                        <p><b>ACCÈS SEGUR I RESTRINGIT</b></p>
                    </div>
                    <div class="container-fluid description-prod">
                        <p> Accés segur i restringit a la informació per garantir la privacitat i la
                            confidencialitat de les
                            dades dels estudiants i les empreses.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Formulari-->
    <section class="  form-section">
        <div class=" container div-form-section">
            <h1 id="contacte">CONTACTA'NS</h1>
            <hr>
            <form action="" method="post">
                <div><label for="nom">Nom</label></div>
                <div> <input type="text"></div>
                <div> <label for="lastname">Cognoms</label></div>
                <div> <input type="text"></div>
                <div> <label for="mail">E-mail</label></div>
                <div> <input type="text"></div>
                <div> <label for="mail">Escriu-nos, atendrem la teva sol·licitud al més aviat possible</label></div>
                <div> <textarea name="question" id="question" cols="30" rows="10"></textarea></div>
                <button type="button" class="btn colorbutton">SEND</button><br><br>

            </form>
            <div class="textlegal">
                <div>
                    <p>(*) D'acord amb el que s'estableix en el Reglament (UE) 2016/679, de 27 d'abril de 2016,
                        relatiu
                        a la protecció de les persones físiques quant al tractament de dades personals i a la lliure
                        circulació d'aquestes dades (***RGPD), l'informem que les dades facilitades seran
                        incorporats en
                        els fitxers titularitat de *Autotech SL amb la finalitat de gestionar i atendre
                        la seva consulta o sol·licitud. La base legal per al tractament de les dades és la
                        legitimació
                        per consentiment de l'interessat. Les seves dades no se cediran a tercers excepte en els
                        casos
                        que existeixi una obligació legal. Les dades proporcionades es conservaran durant el període
                        màxim de 12 mesos.</p>

                    <p>>Ho informem que pot exercitar els seus drets d'accés, rectificació, supressió, limitació del
                        tractament, portabilitat de les dades i oposició, així com revocar el consentiment prestat
                        per a
                        l'enviament de comunicacions comercials enviant un correu electrònic a info@rocavila.com o
                        bé
                        dirigint la seva sol·licitud per escrit a *Autotech SL adjuntant còpia del seu DNI.</p>

                    <p>Li ho informa especialment que *Autotech SL no pren decisions automatitzades
                        sobre aquesta mena de dades. Així mateix, ho informem que vostè té dret a presentar una
                        reclamació davant l'Agència Espanyola de Protecció de Dades (AEPD) en www.aepd.es</p>
                    <br>
                    <br>
                </div>
            </div>
        </div>

    </section>
    <footer class="footer mt-auto py-3">
        <div class="container text-center">
            <span>© 2023 AUTOTECH SL.</span>
        </div>
    </footer>
</template>

<script>
window.onload = function () {
    document.addEventListener('scroll', logoAppear);
    document.getElementById('linkLogo').addEventListener('click', play);
}

function logoAppear() {

    let scrollY = window.scrollY;
    let scrollX = window.scrollX;

    //console.log(scrollY);
    if (scrollY > 7) {
        document.getElementById('linkLogo').setAttribute('style', 'display:flex');
    } else {
        document.getElementById('linkLogo').setAttribute('style', 'display:none');
    }
}

function play() {
    document.getElementById('audio').play();
}
</script>