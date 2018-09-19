<template>
  <div class="contact__form-wrapper">
    <form id="contact-form" class="contact__form z-depth-3">
      <div class="form-group firstname">
        <input id="firstname" :class="{ 'form-error': !validate.nameIsValid }"
               class="input" type="text"
               @blur="removeError"
               placeholder="Imię i nazwisko" v-model="dataForm.name">

      </div>
      <div class="form-group email">
        <input id="email" :class="{ 'form-error': !validate.emailIsValid }"
               class="input" type="email"
               @blur="removeError"
               placeholder="E-mail" v-model="dataForm.email"/>
      </div>
      <div class="form-group topic">
        <input id="topic" :class="{ 'form-error': !validate.topicIsValid }"
               class="input" type="text"
               @blur="removeError"
               placeholder="Temat wiadomości" v-model="dataForm.topic">

      </div>
      <div class="form-group message">
      <textarea id="message" :class="{ 'form-error': !validate.messageIsValid }"
                class="input"
                @blur="removeError"
                placeholder="Masz pytania? Pisz śmiało ;)" v-model="dataForm.message"></textarea>

      </div>
      <button class="main-button center-block" type="submit" @click="sendMessage">
        Wyślij
      </button>
    </form>
    <transition name="quick-fade">
      <div class="loader" v-show="loading">
        <loader></loader>
      </div>
    </transition>
    <vue-toast ref="toast"></vue-toast>
  </div>
</template>
<script>
  import {isMail, isName, isSafe} from '../../../js/helper';
  import Waves from 'node-waves/dist/waves';
  import VueToast from 'vue-toast';
  import Loader from '../../loader.vue';
  export default {
    name: 'contact-form',
    props: ['defines'],
    components: {
      VueToast, Loader
    },
    data() {
      return {
        dataForm: {
          name: this.name ? this.name : '',
          topic: this.topic ? this.topic : '',
          email: this.email ? this.email : '',
          message: this.message ? this.message : ''
//          name: 'Janusz Nowak',
//          topic: 'Axios Test',
//          email: 'asd@o2.pl',
//          message: 'Testowa wiadomość'
        },
        validate: {
          emailIsValid: true,
          nameIsValid: true,
          topicIsValid: true,
          messageIsValid: true,
        },
        toastConfig: {
          position: 'bottom right',
        },
        loading: false,
      }
    },
    created(){
      Waves.init();
      Waves.attach('.main-button');
      document.addEventListener('beforeSend', () => {
        this.showToast('Wysyłanie wiadomości, proszę czekać', 'default');
        this.loading = true;
      });
      document.addEventListener('contactFormSend', () => {
        this.showToast('Wiadomość wysłano pomyślnie, niedługo się odezwę', 'success');
        this.loading = false;
        this.resetData();
      });

      document.addEventListener('failSendForm', () => {
        this.showToast('Upsss.. coś poszło nie tak, spróboj ponownie', 'error');
        this.loading = false;
      });
    },
    methods: {
      sendMessage(event) {
        event.preventDefault();
        let validated = this.validateData();

        if (validated) {
          this.$store.dispatch('sendContactForm', this.dataForm)
        }
      },

      validateData() {
        let result = true;
        let name = this.dataForm.name;
        let email = this.dataForm.email;
        let topic = this.dataForm.topic;
        let message = this.dataForm.message;

        isMail(email) ? this.validate.emailIsValid = true : this.validate.emailIsValid = false;
        isName(name) ? this.validate.nameIsValid = true : this.validate.nameIsValid = false;
        isSafe(topic) ? this.validate.topicIsValid = true : this.validate.topicIsValid = false;
        isSafe(message) ? this.validate.messageIsValid = true : this.validate.messageIsValid = false;

        for (let key in this.dataForm) {
          let value = this.dataForm[key];
          if (value === '') {
            result = false;
            this.showToast('Wypełnij brakujące pole', 'error');
            return result;
          }
        }
        for (let key in this.validate) {
          let value = this.validate[key];
          result = false;
          if (!value && value !== '') {
            if (key === 'emailIsValid') {
              return result;
            }
            return result;
          }
          else {
            result = true;
          }
        }
        return result;
      },
      showToast(txt, theme = 'success', lifetime = 30000, position = 'bottom right', maxToasts = 2){
        let toast = this.$refs.toast;
        toast.setOptions({lifetime, position, maxToasts});
        toast.showToast(txt, {theme});

      },
      removeError(e){
        e.target.classList.remove('form-error');
      },
      resetData() {
        let contactForm = document.querySelector('#contact-form');
        contactForm.classList.add('was-send');
        setTimeout(() => {
          this.dataForm.name = '';
          this.dataForm.topic = '';
          this.dataForm.email = '';
          this.dataForm.message = '';
          contactForm.classList.remove('was-send');
        }, 300);

      }
    }
  }
</script>
