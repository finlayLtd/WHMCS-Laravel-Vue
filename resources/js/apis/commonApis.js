import axios from '../plugins/axios'
import { defineStore } from 'pinia'

export const commonApis = defineStore('commonApis', {
  actions: {
    // 👉 Fetch users data
    
    runGetApi(url , params) { return axios.get(url, { params })},
    
    runPostApi(url , params) { return axios.post(url, { params })},

   
  },
})
