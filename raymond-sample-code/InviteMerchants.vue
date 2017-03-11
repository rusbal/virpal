<template>
    <div class="ui container">
        <vuetable ref="vuetable"
            :api-url="apiUrl"
            :fields="fields"
        ></vuetable>
    </div>
</template>

<script>
import Vuetable  from 'vuetable-2/src/components/Vuetable.vue'

import Vue       from 'vue'
import Actions   from './invite_merchants/Actions.vue'
Vue.component('actions', Actions)

export default {
    props: ['apiUrl'],
    components: {
        Vuetable
    },
    data() {
        return {
            fields: [
                'email',
                {
                    name: '__component:actions',
                    title: 'Action',
                    titleClass: 'center aligned',
                    dataClass: 'center aligned'
                }
            ]
        }
    },
    computed: {
        apiNewUrl() {
            return this.apiUrl
        }
    },
    events: {
        'delete-email' (data, idx) {
            data.sent_at = 0 // processing

            axios.delete(
                '/delete/merchant-emails/' + data.id

            ).then((response) => {
                this.$refs.vuetable.tableData.splice(idx, 1)

            }).catch((response) => {
                data.sent_at = null // reset
                alert('Failed to delete this item.  Please try again.')
            });
        },
        'enqueue-email' (data) {
            data.enqueue = 0 // processing

            axios.patch(
                '/enqueue/merchant-emails/' + data.id

            ).then((response) => {
                data.enqueue = true

            }).catch((response) => {
                data.enqueue = null // reset
                alert('Failed to enqueue this email.  Please try again.')
            });
        }
    }
}
</script>
