import {defineStore} from "pinia";

export const useUsersStore = defineStore("users", {
    state: () => ({
        users: [],
    }),

    actions: {
        setUsers(users) {
            this.users = users
        },

        addUser(user) {
            if (this.users.some(u => u.id === user.id)) {
                return;
            }
            this.users.push(user);
        },

        removeUser(user) {
            this.users = this.users.filter(u => u.id !== user.id);
        }
    },

    getters: {
        allUsers(state) {
            return state.users
        },
        count(state) {
            return state.users.length
        }
    }
});