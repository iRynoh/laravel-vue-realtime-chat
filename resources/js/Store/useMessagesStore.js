import {defineStore} from "pinia";
import axios from "axios";

export const useMessagesStore = defineStore("messages", {
    state: () => ({
        page: 1,
        messages: []
    }),

    actions: {
        async fetchState(roomSlug, page = 1) {
            try {
                const response = await axios.get(`/rooms/${roomSlug}/messages`);
                const data = response.data;
                this.page = data.meta.current_page
                this.messages = [...this.messages, ...data.data]
            } catch (e) {
                console.log('Error getting the messages for room', e);
            }
        }
    },

    getters: {
        allMessages(state) {
            return state.messages;
        },
    }
});
