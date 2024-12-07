import {defineStore} from "pinia";
import axios from "axios";

export const useMessagesStore = defineStore("messages", {
    state: () => ({
        page: 1, messages: [], pageCount: 20
    }),

    actions: {
        fetchState(roomSlug, page = 1) {
            axios.get(`/rooms/${roomSlug}/messages?page=${page}`).then((response) => {
                const data = response.data;
                this.page = data.meta.current_page
                this.pageCount = data.meta.per_page
                this.messages = [...this.messages, ...data.data]
            }).catch((error) => {
                console.log('Error fetching messages', error);
            });

        },

        fetchPreviousState(roomSlug) {
            this.fetchState(roomSlug, this.page + 1);
        },

        pushMessage(message) {
            if (this.messages.length > this.pageCount) {
                // Needed to avoid duplicates as we paginate the old messages.
                this.messages.pop();
            }
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

        clearMessages() {
            this.messages = [];
        }
    },

    getters: {
        allMessages(state) {
            return state.messages;
        },
    }
});
