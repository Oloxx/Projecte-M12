<script setup>
import DropdownLink from "@/Components/DropdownLink.vue";
import { Link, usePage } from "@inertiajs/vue3";
import Footer from "@/Components/Footer.vue";
import BToast from "@/Components/BToast.vue";

const page = usePage();

const user = page.props.auth.user;
const profile = `https://ui-avatars.com/api/?name=${user.name}+${user.cognoms}`;

</script>

<template>
    <div class="p-3 bg-light">
        <img src="../../img/logo/logo_IES.png" alt="Logo IES Carles Vallbona"/>
    </div>
    <header class="p-3 p-e-5 mb-3 border-bottom colorvb">
        <div class="container-flex">
            <div class="d-flex align-items-center justify-content-center justify-content-lg-start px-5">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li>
                        <Link :href="route('empresa.index')" class="nav-link px-2 link-light">{{ $t("Empresa") }}</Link>
                    </li>
                    <li>
                        <Link :href="route('collaboracio.index')" class="nav-link px-2 link-light">{{ $t("Col·laboracions") }}</Link>
                    </li>
                    <li>
                        <Link :href="route('contacte.index')" class="nav-link px-2 link-light">{{ $t("Contactes") }}</Link>
                    </li>
                </ul>

                <div class="dropdown text-end">
                    <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img :src="profile" alt="Foto de perfil" width="32" height="32" class="rounded-circle" />
                    </a>
                    <ul class="dropdown-menu text-small">
                        <li>
                            <DropdownLink class="dropdown-item" :href="route('profile.edit')">
                                <i class="bi bi-person"></i>
                                Perfil
                            </DropdownLink>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <DropdownLink class="dropdown-item" :href="route('logout')" method="post" as="button">
                                <i class="bi bi-box-arrow-right"></i>
                                Surt
                            </DropdownLink>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <slot></slot>
    <BToast />
    <Footer />
</template>
