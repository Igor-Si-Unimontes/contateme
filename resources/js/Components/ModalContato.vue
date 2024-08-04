<script setup>
import { useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import { ref, watch, onMounted } from 'vue';

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
    imagem: null,
});

const formatPhoneNumber = (number) => {
    if (!number) return '';

    number = number.replace(/\D/g, '').slice(0, 11);

    if (number.length <= 10) {
        return number.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
    } else {
        return number.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
    }
};

const save = () => {
    if (form.telefone) {
        form.telefone = formatPhoneNumber(form.telefone);
    }

    const formData = new FormData();
    formData.append('id', form.id);
    formData.append('telefone', form.telefone);
    formData.append('nome', form.nome);
    formData.append('email', form.email);
    formData.append('imagem', form.imagem);

    form.post(route('contato.store'), {
        data: formData,
        headers: {
            'Content-Type': 'multipart/form-data',
        },
        onSuccess: () => sair(),
        onError: () => {
            imagePreview.value = '';
        },
    });
};

const update = () => {
    var id = document.getElementById('id2').value;
    var imagem = document.querySelector('input[type="file"]');
    form.imagem = imagem.files[0];

    if (form.telefone) {
        form.telefone = formatPhoneNumber(form.telefone);
    }

    const formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('id', form.id);
    formData.append('telefone', form.telefone);
    formData.append('nome', form.nome);
    formData.append('email', form.email);
    formData.append('imagem', form.imagem);

    form.put(route('contato.update', id), {
        onSuccess: () => sair(),
        onError: (errorResponse) => {
            errors.value = formatErrors(errorResponse);
            imagePreview.value = "";
        },
    });
};

const sair = () => {
    form.reset();
    document.querySelector('#sair' + props.op).click();
};

const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.imagem = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const imagePreview = ref("");

const previewImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
        form.imagem = file;
    }
};

onMounted(() => {
    if (props.contato.imagem) {
        imagePreview.value = props.contato.imagem;
    }
});

watch(() => form.errors, (newErrors) => {
    if (Object.keys(newErrors).length === 0) {
        imagePreview.value = '';
    }
});
</script>


<script>
export default {
  data() {
    return {
      form: {
        id: '',
        telefone: ''
      }
    };
  },
  computed: {
    formattedTelefone() {
      return this.formatPhoneNumber(this.form.telefone);
    }
  },
  methods: {
  formatPhoneNumber(number) {
    number = number.replace(/\D/g, '').slice(0, 11);

    if (number.length <= 10) {
      return number.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
    } else {
      return number.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
    }
  },
  updateTelefone(event) {
    let rawValue = event.target.value.replace(/\D/g, '').slice(0, 11);

    this.form.telefone = rawValue;

    this.$nextTick(() => {
      let formattedValue = this.formatPhoneNumber(this.form.telefone);
      if (event.target.value !== formattedValue) {
        event.target.value = formattedValue;
        this.form.telefone = rawValue;  // Atualiza o telefone sem a máscara
      }
    });
  }
}
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
                            <TextInput 
                            :id="'telefone'+op" 
                            class="form-control" 
                            type="text" 
                            name="telefone" 
                            v-model="form.telefone"
                            @input="updateTelefone"
                            aria-placeholder="Número de Telefone" 
                            required>
                            </TextInput>
                        </div>
                        <div v-if="form.errors.telefone" class="text-sm text-danger">
                            {{ form.errors.telefone }}
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            <TextInput :id="'nome'+op" class="form-control" type="text" name="nome" v-model="form.nome" maxlength="100" aria-placeholder="Nome do Contato" required></TextInput>
                        </div>
                        <div v-if="form.errors.nome" class="text-sm text-danger">
                            {{ form.errors.nome }}
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <TextInput :id="'email'+op" class="form-control" type="text" name="email" v-model="form.email" maxlength="100" aria-placeholder="Email do Contato" required></TextInput>
                        </div>
                        <div v-if="form.errors.email" class="text-sm text-danger">
                            {{ form.errors.email }}
                        </div>
                         <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-image"></i></span>
                            <input 
                                :id="'imagem' + op" 
                                class="form-control" 
                                type="file" 
                                name="imagem" 
                                @change="previewImage" 
                                :required="op === '1'"
                            />
                        </div>
                        <div v-if="imagePreview" class="mb-3">
                            <img :src="imagePreview" alt="Pré-visualização" class="img-fluid" />
                        </div>
                        <div class="d-grid mx-auto">
                            <button class="btn btn-success" :disabled="form.processing">
                                <i class="fa-solid fa-floppy-disk"></i>Salvar
                            </button>
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
