import Axios from 'axios';
import _ from 'lodash';
import Vue from 'vue';

new Vue({
  el: '#app',
  data:{
    // Data
    id: document.querySelector('meta[name="user_id"]').content,
    isSearching : false,
    search: '',
    messages: [],
    users: [],
    user_from: {
      id: '',
      name: '',
    },
    previewImage: null,
    form: {
      to_user_id: '',
      messages: '',
      image : null,
    },
    isActive: null,
    notif: 0,
  },
  mounted() {
    this.fetchUser(); // get all user in chat
    this.fetchPusher(); // for running laravel echo and pusher
  },
  methods: {
    // checkout all users
    fetchUser() {
      let q;
      const dataUser = this.$refs.userSearch;
      const queryUser = dataUser.dataset.user;
      if (queryUser && queryUser != '') {
        this.search = queryUser;
      }
      q = _.isEmpty(this.search) ? 'all' : this.search;
      this.isSearching = true;
      Axios.get('/message/user/' + q).then(({ data }) => {
        this.users = data;
        this.isSearching = false;
      });
    },

    clearSearch() {
      this.search = '';
    },

    // checkout all admin
    fetchAdmin() {
      this.isSearching = true;
      Axios.get('/message/user/admin').then(({ data }) => {
        this.users = data;
        this.isSearching = false;
      });
    },

    // checkout messages from spesific users
    fetchMessage(id) {
      this.form.to_user_id = id;
      Axios.get('/message/user-message/' + id).then(({ data }) => {
        this.messages = data;
        this.isActive = this.users.findIndex((s) => s.id === id);
        this.users[this.isActive].count = 0;
        this.notif--
      });

      Axios.get('/message/user-from/' + id).then(({ data }) => {
        this.user_from.id = data.id;
        this.user_from.name = data.name;
      });
    },

    // remove image
    removeImage() {
      this.form.image = null;
      this.previewImage = null;
    },

    
    // sending messages
    sendMessage() {

      if (this.form.messages == '' && this.form.image == null) {
        alert('Harap mengisi pesan Anda');
      } else {
        var formData = new FormData();
        formData.append('messages', this.form.messages);
        if (this.form.image != null) {
          formData.append('image', this.form.image);
        }
        formData.append('to_user_id', this.form.to_user_id);
        Axios.post('/message/user-message', formData).then(({data}) => {
          // var res = data.data;
          this.pushMessage(data, data.to_user_id);
          this.form.messages = '';
          this.form.image = null;
          this.previewImage = null;
          this.search = '';
        })
      }
    },

    // keypres textarea chat
    press : function ($event) {
      if ($event.keyCode == 13 && !$event.shiftKey) {
        $event.preventDefault();
        this.sendMessage();
        return true;
      }
    },

    // function for push laravel echo and pusher
    fetchPusher() {
      window.Echo.private('user-message.' + this.id)
          .listen('MessageSent', (e) => {
            this.pushMessage(e, e.from_id, 'push')
          });
    },

    // on file change() 
    fileChange(event) {
      var fileData = event.target.files[0];
      this.form.image = fileData;
      this.previewImage = URL.createObjectURL(fileData);
    },
    // Execution time
    pushMessage(data, user_id, action = '') {
      let self = this
      let index = this.users.findIndex((s) => s.id === user_id);
      if (index != -1 && action == 'push') {
        this.users.splice(index, 1) //delete user
      }

      // for submit message
      if (action == '') {
        
        // this.users[index] = data;
        self.users[index] = data;
        let user = self.users[index];
      } else {
        // for message from laravel echo
        this.users.unshift(data) //add new user to the top
      }

      // if current user got message from spesific user
      if (this.form.to_user_id != '') {
        index = this.users.findIndex((s) => s.id === this.form.to_user_id);
        this.users[index].count = 0;
        this.isActive = index;
        this.messages.push({
          messages     : data.messages,
          created_at  : data.created_at,
          user_id     : data.from_id,
          to_user_id  : data.to_user_id,
          image : data.image != null ? data.image : null,
          isOwn : true,
        });
        Axios.get('/message/user-messages/' + user_id + '/read')
        // if (this.form.to_user_id === user_id) {
        // }
      }
    },

    //scroll to top chat
    scrollToEnd: function() {
      let container = this.$el.querySelector('#card-message-scroll');
      container.scrollTop = container.scrollHeight;
    }
  },
  watch: {
    search: _.debounce( function() {
      this.fetchUser()
    }, 500),
    // untuk menambahakan jumlah notifikasi berdasarkan perubahan variable users
    users: _.debounce( function() {
        this.notif = 0
        this.users.filter(e => {
            if (e.count) {
                this.notif++
            }
        })
    }),
    // setiap ada pesan baru akan memanggil this.scrollToEnd()
    messages: _.debounce( function() {
        this.scrollToEnd()
    }, 10)
  },
})