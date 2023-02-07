<template>
    <GuestLayout>
        <Head title="Register" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <ValidationErrors class="mb-4" />
        <el-form @submit.prevent="submit" label-width="auto" label-position="top">
           <el-form-item label="Name">
               <el-input
                   minlength="3"
                   maxlength="25"
                   id="username"
                   type="text"
                   class="mt-1 block w-full"
                   v-model="form.name"
                   required
                   autofocus
                   autocomplete="username"
               />
           </el-form-item>
            <el-form-item  label="Phone">
                <el-input
                    id="phone"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    required
                    v-mask="'+38(0##)-###-##-##'"
                ></el-input>
            </el-form-item>

            <div class="flex items-center justify-center mt-4">
                <el-button type="info" class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="submit">register</el-button>
            </div>
        </el-form>
    </GuestLayout>
</template>

<script>
import ValidationErrors from '@/Components/ValidationErrors.vue';
import GuestLayout from '@/Layouts/Guest.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { mask } from 'vue-the-mask';

export default {
    name: "Register",
    components: {
        GuestLayout,
        ValidationErrors,
        Head,
        useForm
    },
    props: {
        canResetPassword: Boolean,
        status: String,
    },
    directives: {
      mask
    },
    data(){
        return {
            form: this.$inertia.form({
                name: '',
                phone: ''
            })
        }
    },
    methods:{
      submit: function (){
          let self = this
          this.form.post(this.route('register'), {
              onFinish: () => self.form.reset(),
          });
      }
    }
}
</script>
<style>
.el-input__inner {
    border: 0 none!important;
    box-shadow: none!important;
}
.el-input-group__prepend {
    background-color: var(--el-fill-color-blank);
}
</style>
