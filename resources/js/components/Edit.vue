<template>
  
</template>

<script>
import { EventBus } from "../event-bus.js";

export default {
  props: ["modelname"],
  data() {
    return {
      mode: "create",
      editid: null,
      cruddata: {}
    };
  },
  mounted() {
    EventBus.$on("edit", payload => {
      console.log("edit");
      this.mode = "edit";
      this.editid = payload;|
    });
  },
  methods: {
    add() {
      let self = this;
      axios
        .post("/" + this.modelname.toLowerCase(), this.cruddata)
        .then(res => self.emitReload());
    },
    reset() {
      this.cruddata = {};
    },
    emitReload() {
      this.reset();
      EventBus.$emit("reload", "");
    }
  },
  computed: {
    action() {
      return "/" + this.modelname.toLowerCase();
    }
  }
};
</script>