<script setup>
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import { mask } from 'vue-the-mask';

const props = defineProps({
    contato: { type: Object, default: () => ({}) },
    modal: String,
    telefone: String,
    op: String,
});

const form = useForm({
    id: props.contato.id,
    telefone: props.contato.telefone,
    nome: props.contato.nome,
    email: props.contato.email,
    imagem: props.contato.imagem,
});

watch(() => props.contato, (newContato) => {
    form.id = newContato.id;
    form.telefone = newContato.telefone;
    form.nome = newContato.nome;
    form.email = newContato.email;
    form.imagem = newContato.imagem;

}, { deep: true });


const sair = () => {
    form.reset();
    document.querySelector('#sair' + props.op).click();
};
</script>



<template>
    <div class="modal fade" :id="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <label class="h5">{{ telefone }}</label>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="(op === '1' ? save() : update())">
                    <TextInput :id="'id'+op" type="hidden" name="id" v-model="form.id"></TextInput>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                        <TextInput :id="'telefone3'" class="form-control" type="text" name="telefone" v-model="form.telefone" maxlength="11" aria-placeholder="Número de Telefone" readonly></TextInput>
                    </div>
                    <div v-if="form.errors.telefone" class="text-sm text-danger">
                        {{ form.errors.telefone }}
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                        <TextInput :id="'nome3'" class="form-control" type="text" name="nome" v-model="form.nome" maxlength="100" aria-placeholder="Nome do Contato" readonly></TextInput>
                    </div>
                    <div v-if="form.errors.nome" class="text-sm text-danger">
                        {{ form.errors.nome }}
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                        <TextInput :id="'email3'" class="form-control" type="text" name="email" v-model="form.email" maxlength="100" aria-placeholder="Email do Contato" readonly></TextInput>
                    </div>
                    <div v-if="form.errors.email" class="text-sm text-danger">
                        {{ form.errors.email }}
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-dark" type="button" :id="'sair'+op" data-bs-dismiss="modal">Sair</button>
            </div>
        </div>
    </div>
</div>

</template>
