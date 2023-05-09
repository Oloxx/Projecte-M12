<script setup>
import InputError from '@/Components/InputError.vue';
import BModal from '@/Components/BModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import * as bootstrap from 'bootstrap';
import { nextTick, ref } from 'vue';

const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onBefore: () => closeModal(),
        onError: () => openModal(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    const modal = bootstrap.Modal.getInstance(document.getElementById('Modal'));
    modal.hide();
    form.reset();
};

const openModal = () => {
    const modal = new bootstrap.Modal('#Modal');
    modal.show();
    passwordInput.value.focus();
}
</script>

<template>
    <section class="mb-5">
        <header>
            <h2>{{ $t("Esborrar compte") }}</h2>

            <p class="mt-1">
                {{ $t("Un cop suprimit el teu compte, tots els teus recursos i dades s'esborraran permanentment.") }}
            </p>
        </header>

        <PrimaryButton @click="confirmUserDeletion(); openModal()">
            {{ $t("Esborrar compte") }}
        </PrimaryButton>

        <BModal class="modal-lg">
            <template #header>
                <h3>{{ $t("Esteu segur que voleu esborrar el vostre compte?") }}</h3>
            </template>
            <template #body>
                <p>
                    {{ $t("Un cop eliminat el vostre compte, tots els seus recursos i dades s'esborraran permanentment.") }}<br>
                    {{ $t("Introduïu la vostra contrasenya per confirmar que voleu eliminar el vostre compte permanentment.") }}
                </p>
                <div class="mt-4">
                    <TextInput id="password_con" ref="passwordInput" v-model="form.password" type="password" class="mt-1"
                        :placeholder="$t(`Contrasenya`)" @keyup.enter="deleteUser" style="max-width: 400px;" />
                    <InputError :message="form.errors.password" class="mt-2" />
                </div>
            </template>
            <template #button>
                <PrimaryButton @click="deleteUser" >
                    {{ $t("Elimina") }}
                </PrimaryButton>
            </template>
        </BModal>
    </section>
</template>
