import Vue from 'vue';
import {MAIN_MENU_ID, FOOTER_MENU_ID} from './data';
import { componentNeedUpdate, getComponentName } from './helper';
export const actionsCreators = () => {
  return {
    getMenu: (context, menuID) => {
      Vue.http
          .get('/wp-json/wp-api-menus/v2/menus/' + menuID)
          .then((resp) => {
            let data = resp.body;
            if (menuID === MAIN_MENU_ID) {
              context.commit('setMenuLinks', data.items)
            }
            if (menuID === FOOTER_MENU_ID) {
              context.commit('setFooterMenuLinks', data.items);
              context.commit('setFooterMenuTitle', data.name)
            }
          });
    },
    fetchContentSite: (context, params) => {
      console.log(params)
      // let doesNeedUpdate = componentNeedUpdate(params.ID);
      // if (doesNeedUpdate) {
        Vue.http
          .get('/wp-json/wp/v2/pages/'+params.ID)
          .then((resp) => {
            let data = resp.body.content.rendered;
            console.log(data)
            context.commit('setCmsData', data)
          });
      // }

      },
    fetchDataPage: (context, params) => {
      let doesNeedUpdate = componentNeedUpdate(params.ID);
      if (doesNeedUpdate) {
        Vue.http
            .get('/wp-json/acf/v2/post/' + params.ID)
            .then((resp) => {
              let data = resp.body.acf;
              params.chunks.forEach((item) => {
                context.commit(item.method, data[item.chunkType]);
              });
            });
      }

    },
    getWidget(context, name){
      Vue.http
          .get('/wp-json/wp-rest-api-sidebars/v1/sidebars/' + name)
          .then(response => {
            context.commit('setFooterWidget', response.body)
          }, response => {
            console.log('Sidebar could not be loaded', +response)
          });

    },

    sendContactForm(context, params){
      let beforeSend = new Event('beforeSend');
      document.dispatchEvent(beforeSend);
      Vue.http
          .post('/wp-admin/admin-ajax.php',
              {
                'action': 'send_mail',
                'data': params,
              },
          ).then(response => {
        let contactFormSend = new Event('contactFormSend');
        contactFormSend.data = response;
        document.dispatchEvent(contactFormSend);
      }, response => {
        let failSendForm = new Event('failSendForm');
        document.dispatchEvent(failSendForm);
      });
    }
  }
};