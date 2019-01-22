<template>
    <div class="home-w">
        <div class="home-nav-w">
            <nav class="nav nav-pills nav-justified">
                <a v-for="page in pages" :key="page.name" :class="['nav-item nav-link nav-php-challenge', page.active ? 'active' : '', page.completed ? 'completed' : '']"> {{ page.name }}</a>
            </nav>
        </div>
        <div class="home-main-w">
            <register v-if="pages[0].active" @goToNext="goToNext"></register>
            <checkout v-if="pages[1].active" :user="user"></checkout>
        </div>
    </div>
</template>
<script>
import Register from '../components/Register.component';
import Checkout from '../components/Checkout.component';
export default {
    name: 'Home',
    data: function() {
        return {
            pages: [
                {
                    name: 'Cadastro',
                    active: true,
                    completed: false
                },
                {
                    name: 'Pagamento',
                    active: false,
                    completed: false
                },
            ],
            user: {}
        }
    },
    methods: {
        goToNext: function(user) {
            this.user = user;

            this.pages[0].active = false;
            this.pages[0].completed = true;
            
            this.pages[1].active = true;
        }
    },
    components: {
        Register,
        Checkout
    }
}
</script>

