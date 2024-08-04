<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ModalContato from '@/Components/ModalContato.vue';
import ModalView from '@/Components/ModalView.vue';
import Swal from 'sweetalert2';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { result } from 'lodash';

const form = useForm({});
const props = defineProps({
    contatos:{type:Object}
});
const eliminar = (id,name) =>{
    const swalWithBoostrapButtons = Swal.mixin({
        buttonsStyling:true
    })
    swalWithBoostrapButtons.fire({
        title:'Tem certeza que deseja apagar o contato ' +name,
        text: '',
        icon: 'question',
        showCancelButton:true,
        confirmButtonText: '<i class = "fa-solid fa-check"></i> Sim, Apagar',
        cancelButtonText:'<i class = "fa-solid fa-ban"></i> Cancelar'
    }).then((result) => {
        if(result.isConfirmed){
            form.delete(route('contato.destroy',id));
        }
    })
}

const openModal = (contato) => {
    const idElement = document.getElementById('id2');
    const telefoneElement = document.getElementById('telefone2');
    const nomeElement = document.getElementById('nome2');
    const emailElement = document.getElementById('email2');
    const imageElement = document.getElementById('imagemPreview2');

    if (idElement) idElement.value = contato.id;
    if (telefoneElement) telefoneElement.value = contato.telefone;
    if (nomeElement) nomeElement.value = contato.nome;
    if (emailElement) emailElement.value = contato.email;
    if (imageElement) {
        imageElement.src = contato.imagem ? `${contato.imagem}` : '';
    }
};
const openModalView = (contato) => {
    const idElement = document.getElementById('id3');
    const telefoneElement = document.getElementById('telefone3');
    const nomeElement = document.getElementById('nome3');
    const emailElement = document.getElementById('email3');
    const imagemElement = document.getElementById('imagem3');

    if (idElement) idElement.value = contato.id;
    if (telefoneElement) telefoneElement.value = contato.telefone;
    if (nomeElement) nomeElement.value = contato.nome;
    if (emailElement) emailElement.value = contato.email;
    if (imagemElement) imagemElement.value = contato.imagem;

};

</script>
<template>
    <Head title="Contatos"></Head>
    <AuthenticatedLayout>
        <template #header>
            <div class="container-fluid mt-3 bg-white">
                <div class="row mt-3">
                    <div class="col-md-4 offset-md-4">
                        <div class="d-grid mx-auto">
                            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalCreate">
                                <i class="fa-solid fa-circle-plus"></i>
                                Criar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-10 offset-md-1">
                        <div class="table-responsive">
                            <table class="table table-stripeted table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Telefone</th>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Imagem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="contato, i in contatos" :key="contato.id">
                                        <td>{{ i+1 }}</td>
                                        <td>{{ contato.telefone }}</td>
                                        <td>{{ contato.nome }}</td>
                                        <td>{{ contato.email }}</td>
                                        <td>
                                        <img 
                                            v-if="contato.imagem" 
                                            :src="`${contato.imagem}`" 
                                            alt="Imagem do Contato" 
                                            class="img-thumbnail" 
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;"
                                        >
                                        <span v-else>Nenhuma imagem</span>
                                    </td>
                                  <td>
                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit" @click="openModal(contato)">
                                                <i class="fa-solid fa-edit"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" @click="eliminar(contato.id,contato.telefone)">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>  
                                        </td>
                                        <td>
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalView" @click="openModalView(contato)">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <ModalContato :modal="'modalCreate'" :title="'Criar Contato'" :op="'1'"></ModalContato>
            <ModalContato :modal="'modalEdit'" :title="'Editar Contato'" :op="'2'"></ModalContato>
            <ModalView :modal="'modalView'" :title="'Visualizar Contato'" :op="'3'"></ModalView>
        </template>
    </AuthenticatedLayout>
</template>