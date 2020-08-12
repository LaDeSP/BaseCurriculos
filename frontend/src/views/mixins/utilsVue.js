import moment from 'moment'

export default {
  methods: {
    formatarData(data){
      return moment(data).format('DD/MM/YYYY')
    }
  }
}