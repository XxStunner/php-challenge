<template>
    <div class="register-w">
        <div class="register-h text-center">
            <h2>Realize seu cadastro</h2>
        </div>
        <div class="register-b">
            <form class="form-php-challenge" ref="form" v-on:submit.prevent="submit()">
                <div class="form-group row">
                    <div class="col-12">
                        <h5><i class="fas fa-address-card"></i> Info. Pessoal</h5>
                        <hr>
                    </div>
                    <div class="col-12">
                        <input v-model="user.name" class="form-control control-php-challenge" placeholder="Nome*" type="text" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <input v-model="user.email" :class="['form-control control-php-challenge', user.email && validation.invalidEmail ? 'invalid' : '']" placeholder="E-mail*" type="email" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <input v-model="user.doc" v-mask="'###.###.###-##'" :class="['form-control control-php-challenge', user.doc && validation.invalidDoc ? 'invalid' : '']" placeholder="CPF*" type="text" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <h5><i class="fas fa-home"></i> Endereço</h5>
                        <hr>
                    </div>
                    <div class="col-12">
                        <input v-model="user.address_street" class="form-control control-php-challenge" placeholder="Logradouro*" type="text" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <input v-model="user.address_complement" class="form-control control-php-challenge" placeholder="Complemento" type="text">
                    </div>
                    <div class="col-12 col-md-3">
                        <input v-model="user.address_neighborhood" class="form-control control-php-challenge" placeholder="Bairro*" type="text">
                    </div>
                    <div class="col-12 col-md-3">
                        <input v-model="user.address_city" class="form-control control-php-challenge" placeholder="Cidade*" type="text" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <select v-model="user.address_state" class="form-control control-php-challenge" required>
                            <option v-for="state in states" :key="state.initials" :value="state.initials"> {{ state.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <h5><i class="fas fa-phone"></i> Telefone(s)</h5>
                        <hr>
                    </div>
                    <div v-if="user.phones.length > 0" class="col-12">
                        <div v-for="(phone, index) in user.phones" :key="index" class="phone-w">
                            <div class="phone-l">
                                <input :ref="`phone_${index}`" :value="phone" v-mask="['(##) ####-####', '(##) #####-####']" class="form-control control-php-challenge" placeholder="Telefone com DDD e numero" type="text" required>
                            </div>
                            <div class="phone-r">
                                <button @click="editPhone(index)" class="btn btn-php-challenge pt-0 pb-0 h-100 mr-2" type="button"><i class="fas fa-pencil-alt"></i></button>
                                <button @click="removePhone(index)" class="btn btn-php-challenge d-flex pt-0 pb-0 h-100" type="button"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <input v-model="currentPhone" v-mask="['(##) ####-####', '(##) #####-####']" :class="['form-control control-php-challenge', currentPhone && validation.invalidCurrentPhone ? 'invalid' : '']" placeholder="Telefone com DDD e numero" type="text">
                    </div>
                    <div class="col-12 col-md-4">
                        <button @click="addPhone()" class="btn btn-block btn-php-challenge pt-0 pb-0 h-100" type="button" :disabled="validation.invalidCurrentPhone">Adicionar</button>
                    </div>
                </div>
                <div class="form-group row text-center">
                    <div class="col-12 mb-0">
                        <button class="btn btn-php-challenge" type="submit" :disabled="validation.invalidForm">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import { mask } from 'vue-the-mask';
export default {
    name: 'Register',
    data: function(){
        return {
            user: {
                name: "",
                email: "",
                doc: "",
                address_street: "",
                address_complement: "",
                address_neighborhood: "",
                address_city: "",
                address_state: "AC",
                phones: []
            },
            states: [
                {
                    name: "Acre", 
                    initials: "AC"
                },
                {
                    name: "Alagoas", 
                    initials: "AL"
                },
                {
                    name: "Amapá", 
                    initials: "AP"
                },
                {
                    name: "Amazonas", 
                    initials: "AM"
                },
                {
                    name: "Bahia", 
                    initials: "BA"
                },
                {
                    name: "Ceará", 
                    initials: "CE"
                },
                {
                    name: "Distrito Federal", 
                    initials: "DF"
                },
                {
                    name: "Espírito Santo", 
                    initials: "ES"
                },
                {
                    name: "Goiás", 
                    initials: "GO"
                },
                {
                    name: "Maranhão", 
                    initials: "MA"
                },
                {
                    name: "Mato Grosso", 
                    initials: "MT"
                },
                {
                    name: "Mato Grosso do Sul", 
                    initials: "MS"
                },
                {
                    name: "Minas Gerais", 
                    initials: "MG"
                },
                {
                    name: "Pará", 
                    initials: "PA"
                },
                {
                    name: "Paraíba", 
                    initials: "PB"
                },
                {
                    name: "Paraná", 
                    initials: "PR"
                },
                {
                    name: "Pernambuco", 
                    initials: "PE"
                },
                {
                    name: "Piauí", 
                    initials: "PI"
                },
                {
                    name: "Rio de Janeiro", 
                    initials: "RJ"
                },
                {
                    name: "Rio Grande do Norte", 
                    initials: "RN"
                },
                {
                    name: "Rio Grande do Sul", 
                    initials: "RS"
                },
                {
                    name: "Rondônia", 
                    initials: "RO"
                },
                {
                    name: "Roraima", 
                    initials: "RR"
                },
                {
                    name: "Santa Catarina", 
                    initials: "SC"
                },
                {
                    name: "São Paulo", 
                    initials: "SP"
                },
                {
                    name: "Sergipe", 
                    initials: "SE"
                },
                {
                    name: "Tocantins", 
                    initials: "TO"
                }
            ],
            validation: {
                invalidEmail: true,
                invalidDoc: true,
                invalidForm: true,
                invalidPhones: true,
                invalidCurrentPhone: true
            },
            currentPhone: ""
        }
    },
    methods: {
        /**
         * API Calls
         */
        submit: function() {
            let user = this.user;
            /**
             * Remove chars from doc.
             */
            user.doc = user.doc.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
            /**
             * Remove chars from phone numbers.
             */
            user.phones = user.phones.map(phone => phone.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, ''));
            /**
             * Send the post request.
             */
            window.axios.post('/api/register', user)
                .then(({ data }) => {
                    user.id = data.user_id;
                    this.$emit('goToNext', user);
                })
                .catch(err => console.log(err));
        },
        checkEmail: function(email) {
            return new Promise((resolve, reject) => {
                window.axios.get(`/api/checkemail?email=${email}`)
                    .then(({ data }) => {
                        resolve(data.found);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },
        /**
         * Front-end
         */
        addPhone: function() {
            this.user.phones.push(this.currentPhone);
            this.currentPhone = "";
            this.validation.invalidCurrentPhone = true;
        },
        removePhone: function(index) {
            this.user.phones.splice(index, 1);
        },
        editPhone: function(index) {
            this.user.phones = this.user.phones.map((phone, key) => key === index ? this.$refs[`phone_${index}`][0].value : phone);
        },
        /**
         *  Utils.
         */
        isValidDoc: function(number) {
            let sum;
            let rest;
            sum = 0;
            if (number == "00000000000") return false;

            for (let i=1; i<=9; i++) sum = sum + parseInt(number.substring(i-1, i)) * (11 - i);
            rest = (sum * 10) % 11;

            if ((rest == 10) || (rest == 11))  rest = 0;
            if (rest != parseInt(number.substring(9, 10)) ) return false;

            sum = 0;
            for (let i = 1; i <= 10; i++) sum = sum + parseInt(number.substring(i-1, i)) * (12 - i);
            rest = (sum * 10) % 11;

            if ((rest == 10) || (rest == 11))  rest = 0;
            if (rest != parseInt(number.substring(10, 11) ) ) return false;

            return true;
        },
    },
    computed: {
        computedUser: function() {
            return Object.assign({}, this.user);
        }
    },
    watch: {
        computedUser: {
            handler: async function(newUser, oldUser) {
                /**
                 * Verify email.
                 */
                if(newUser.email && newUser.email !== oldUser.email) {
                    if(/\S+@\S+\.\S+/.test(newUser.email)) {
                        this.validation.invalidEmail = await this.checkEmail(this.user.email);
                    } else {
                        this.validation.invalidEmail = true;
                    }
                }
                /**
                 * Verify doc.
                 */
                if(newUser.doc && newUser.doc !== oldUser.doc) {
                    this.validation.invalidDoc = !this.isValidDoc(newUser.doc.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, ''));
                }
                /**
                 * Verify phones.
                 */
                this.validation.invalidPhones = newUser.phones.length === 0;
                /**
                 * Verify the form.
                 */
                this.validation.invalidForm = this.validation.invalidEmail || this.validation.invalidDoc || this.validation.invalidPhones || !this.$refs.form.checkValidity();
            },
            deep: true
        },
        currentPhone: function(newPhone, oldPhone) {
            if(newPhone) {
                this.validation.invalidCurrentPhone = this.currentPhone.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '').length < 11
            }
        }
    },
    directives: {
        mask
    }
}
</script>
