<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";
import Footer from "@/Components/Footer.vue";
</script>

<template>
    <div class="p-3 bg-light">
        <img src="../../img/logo/logo_IES.png" alt="" />
    </div>
    <header class="p-3 p-e-5 mb-3 border-bottom colorvb">
        <div class="container-flex">
            <div class="d-flex align-items-center justify-content-center justify-content-lg-start px-5">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li>
                        <a href="#" class="nav-link px-2 link-light">Empreses</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-2 link-light">Col·laboracions</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-2 link-light">Contactes</a>
                    </li>
                </ul>

                <div class="dropdown text-end">
                    <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle" />
                    </a>
                    <ul class="dropdown-menu text-small">
                        <li>
                            <a class="dropdown-item" href="#">New project...</a>
                        </li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <DropdownLink class="dropdown-item" :href="route('logout')" method="post" as="button">
                                Log Out
                            </DropdownLink>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <Footer />
</template>
