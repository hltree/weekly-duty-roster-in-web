/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('sweetalert2/dist/sweetalert2.min.css');

import Swal from 'sweetalert2';

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

/**
 * @Route api.update_schedule
 * update schedules from ajax
 */
$(function () {
    const js_schedule_user_button = $('.js-scheduling-user');
    if (0 < js_schedule_user_button.length) {
        js_schedule_user_button.each(function () {
            $(this).on('click', function () {
                const _this = $(this);
                const scheduling_users_cel = $('.js-scheduling-activeUsers-' + _this.data('schedule-id'));
                const user_id = _this.data('user-id');
                const user_name = _this.data('user-name');
                $.ajax({
                    url: '/api/update_schedule',
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        active: _this.data('active'),
                        date: _this.data('date'),
                        userId: user_id,
                        userName: user_name
                    }
                }).then(function (response) {
                    Swal.fire(response['message']);
                    if (200 === response['status']) {
                        if ('insert' === response['actionType']) {
                            _this.removeClass('btn-success');
                            _this.addClass('btn-warning');

                            _this.data('active', 'true');

                            scheduling_users_cel.append('<span class="btn btn-success calendar-table-cel-user" data-user-id="' + user_id + '">' + user_name + '</span>');
                        } else if ('delete' === response['actionType']) {
                            _this.addClass('btn-success');
                            _this.removeClass('btn-warning');

                            _this.data('active', 'false');

                            const remove_element = scheduling_users_cel.find('.calendar-table-cel-user[data-user-id="' + user_id + '"]');

                            $(remove_element).remove();
                        }
                    }
                })
            });
        });
    }
})
