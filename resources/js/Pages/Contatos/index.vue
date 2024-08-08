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
            <div class="container mx-auto mt-3 bg-white p-4">
                <div class="flex justify-end mb-6">
                    <button class="bg-gray-800 text-white py-2 px-4 text-base rounded hover:bg-gray-700 -ml-6 -mb-5" data-bs-toggle="modal" data-bs-target="#modalCreate">
                        <i class="fa-solid fa-circle-plus"></i>
                         Criar
                    </button>
                </div>
                <div class="flex justify-center mt-6">
                    <div class="w-full max-w-6xl">
                        <div class="w-full">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border text-center">#</th>
                                        <th class="px-4 py-2 border text-center">Telefone</th>
                                        <th class="px-4 py-2 border text-center">Nome</th>
                                        <th class="px-4 py-2 border text-center">E-mail</th>
                                        <th class="px-4 py-2 border text-center">Imagem</th>
                                        <th class="px-4 py-2 border text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="contato, i in contatos" :key="contato.id">
                                        <td class="px-4 py-2 border text-left">{{ i+1 }}</td>
                                        <td class="px-4 py-2 border text-left">{{ contato.telefone }}</td>
                                        <td class="px-4 py-2 border text-left">{{ contato.nome }}</td>
                                        <td class="px-4 py-2 border text-left">{{ contato.email }}</td>
                                        <td class="px-4 py-2 border text-center">
                                        <img 
                                            v-if="contato.imagem" 
                                            :src="`${contato.imagem}`" 
                                            alt="Imagem do Contato" 
                                            class="w-12 h-12 object-cover rounded-full mx-auto" 
                                        >
                                        <span v-else>Nenhuma imagem</span>
                                    </td>
                                    <td class="px-4 py-2 flex justify-center items-center space-x-4">
                                            <button class="bg-blue-600 text-white py-1 px-2 rounded hover:bg-blue-400" data-bs-toggle="modal" data-bs-target="#modalView" @click="openModalView(contato)">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            <button class="bg-yellow-500 text-white py-1 px-2 rounded hover:bg-yellow-400" data-bs-toggle="modal" data-bs-target="#modalEdit" @click="openModal(contato)">
                                                <i class="fa-solid fa-edit text-black"></i>
                                            </button>
                                            <button class="bg-red-600 text-white py-1 px-2 rounded hover:bg-red-400" @click="eliminar(contato.id,contato.telefone)">
                                                <i class="fa-solid fa-trash"></i>
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