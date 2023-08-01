<template>
  <div>
    <div></div>
  </div>
</template>
<script>
function revertColor(color) {
		// Convert the color to RGB format
		var r = parseInt(color.substring(1, 3), 16);
		var g = parseInt(color.substring(3, 5), 16);
		var b = parseInt(color.substring(5, 7), 16);

		// Calculate the inverted color
		var invertedR = 255 - r;
		var invertedG = 255 - g;
		var invertedB = 255 - b;

		// Convert the inverted color back to hex format
		var invertedColor = "#" + invertedR.toString(16).padStart(2, '0') + invertedG.toString(16).padStart(2, '0') + invertedB.toString(16).padStart(2, '0');

		return invertedColor;
	}

	export default {
		name : "Chart",
		props: {
			data: Object,
		},
		data : function() {
			return {
				target: undefined
			}
		},
		mounted() { 
			this.target = Highcharts.chart(this.$el, this.data);
		},
		beforeDestroy: function() {
			this.target.destroy();
		},
	}
</script>