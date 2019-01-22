<template>
    <div class="checkout-w">
        <div class="checkout-b" v-show="!loading && !payment.status">
            <div class="text-center">
                <h2>Escolha o plano</h2>
            </div>
            <div class="plans-w">
                <div v-for="plan in plans" :key="plan.id" class="plan-w">
                    <div class="plan-h">
                        <i class="fas fa-cubes"></i>
                    </div>
                    <div class="plan-b">
                        <h3>{{ plan.name }}</h3>
                    </div>
                    <div class="plan-f">
                        <button @click="selectPlan(plan.id)" :class="['btn btn-php-challenge', plan.selected ? 'selected' : '']" type="button" v-html="plan.selected ? `<i class='fas fa-check'></i> Selecionado` : `<i class='fas fa-cart-plus'></i> R$ ${formatNum(plan.price)}`"></button>
                    </div>
                </div>
            </div>
            <div class="checkout-form-w" >
                <form ref="form" class="form-php-challenge" v-on:submit.prevent="submit()">
                    <div class="form-group row">
                        <div class="col-12">
                            <h5><i class="fas fa-address-card"></i> Info. Pessoais</h5>
                            <hr>
                        </div>
                        <div class="col-12">
                            <div class="user-info-w">
                                <div class="user-info-h">
                                    <h4>{{ user.name }} - {{ user.doc }} </h4>
                                    <h5>{{ user.address_street  }}{{ user.address_complement ? `, ${user.address_complement}` : '' }} - {{ user.address_neighborhood }} - {{ user.address_city }} / {{ user.address_state }}</h5>
                                </div>
                                <div class="user-info-b">
                                    <h5>Enail: {{ user.email }}</h5>
                                    <h5>Telefones: </h5>
                                    <ul>
                                        <li v-for="phone in user.phones" :key="phone">{{ phone | formatPhone }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <h5><i class="fas fa-credit-card"></i> Dados do pagamento</h5>
                            <hr>
                        </div>
                        <div class="col-12 col-md-8">
                            <input v-mask="'#### #### #### ####'" v-model="payment.card_number" class="form-control control-php-challenge" placeholder="Número do cartão" type="text" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <input v-model="payment.ccv" class="form-control control-php-challenge" placeholder="CCV" type="number" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <h4>Preço: R$ {{ formatNum(payment.price)  }} / Plano: {{ planName || 'Nenhum plano escolhido' }}</h4>
                        </div>
                    </div>
                    <div class="form-group row text-center">
                        <div class="col-12 mb-0">
                            <button class="btn btn-php-challenge" type="submit" :disabled="validation.invalidForm">Realizar pagamento</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="checkout-loading" v-show="loading">
            <i class="fas fa-circle-notch fa-spin"></i>
            <h2>Processando...</h2>
        </div>
        <div class="checkout-failure" v-show="!loading && payment.status === 'failure'">
            <h2>Falha ao processar o pagamento</h2>
            <button @click="retryPayment()" class="btn btn-php-challenge" type="button">Tentar novamente</button>
        </div>
        <div class="checkout-success" v-show="!loading && payment.status === 'success'">
            <i class="fas fa-smile-wink"></i>
            <h2>Compra efetuada com sucesso!</h2>
        </div>
    </div>
</template>
<script>
import { mask } from 'vue-the-mask';
export default {
    name: 'Checkout',
    props: ['user'],
    data: function() {
        return {
            plans: [],
            payment: {
                user_id: undefined,
                plan_id: undefined,
                card_number: "",
                ccv: "",
                price: 0,
                status: ""
            },
            validation: {
                invalidForm: true
            },
            planName: "",
            loading: false
        }
    },
    methods: {
        /**
         * API.
         */
        getPlans: function() {
            window.axios.get('/api/plans')
                .then(({ data }) => {
                    this.plans = data.items;
                })
                .catch(err => console.log(err));
        },
        submit: async function() {
            this.loading = true;

            let payment = this.payment;

            payment.card_number = this.payment.card_number.replace(/\s/g, '');

            try {
                let { data } = await window.axios.post('/api/charge', payment);
                this.payment.status = data.status;
            } catch (err) {
                if(err.response.status === 400) {
                    this.payment.status = err.response.data.status;
                }
                console.log(err.response);
            }
            
            setTimeout(() => {
                this.loading = false;
            }, 1000); // 1s
        },
        /**
         * Front-end.
         */
        selectPlan: function(id) {
            this.plans = this.plans.map(plan => {
                plan.selected = false;
                if(plan.id === id) {
                    plan.selected = true;
                    this.payment.price = plan.price;
                    this.payment.plan_id = id;
                    this.planName = plan.name
                }
                return plan;
            });
        },
        retryPayment: function() {
            this.payment.status = '';
        },
        /**
         * Utils.
         */
        formatNum: function(number) {
            return Number(number).toLocaleString('pt-BR');
        }
    },
    mounted() {
        this.getPlans();
        this.payment.user_id = this.user.id;
    },
    filters: {
        formatPhone: function(phone) {
            return phone.replace(/\s/g, '').replace(/^([\d]{2})([\d]{1})?([\d]{4})([\d]{4})$/, "($1) $2 $3 - $4");
        }
    },
    watch: {
        payment: {
            handler: function() {
                this.validation.invalidForm = !this.payment.plan_id || !this.$refs.form.checkValidity();
            },
            deep: true
        } 
    },
    directives: {
        mask
    }
}
</script>
