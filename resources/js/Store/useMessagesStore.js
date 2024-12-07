import {defineStore} from "pinia";
import axios from "axios";

export const useMessagesStore = defineStore("messages", {
    state: () => ({
        page: 1, messages: []
    }),

    actions: {
        fetchState(roomSlug, page = 1) {
            axios.get(`/rooms/${roomSlug}/messages?page=${page}`).then((response) => {
                const data = response.data;
                this.page = data.meta.current_page
                this.messages = [...this.messages, ...data.data]
            }).catch((error) => {
                console.log('Error fetching messages', error);
            });

        },

        fetchPreviousState(roomSlug) {
            this.fetchState(roomSlug, this.page + 1);
        },

        pushMessage(message) {
            this.messages.pop() // Needed to avoid duplicates as we paginate the old messages.
            this.messages = [message, ...this.messages];
        },

        storeMessage(roomSlug, payload) {
            axios.post(`/rooms/${roomSlug}/messages`, payload, {
                headers: {
                    'X-Socket-Id': Echo.socketId()
                }
            })
                .then((response) => {
                    this.pushMessage(response.data);
                }).catch((error) => {
                console.log('Error storing message', error);
            })
        },
    },

    getters: {
        allMessages(state) {
            return state.messages;
        },
    }
});
