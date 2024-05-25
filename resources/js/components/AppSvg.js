import { h } from 'vue';
import { merge, pick } from 'lodash';

export default {
  name: 'AppSvg',
  props: {
    icon: {
      required: true,
      type: String
    },
    path: {
      required: false,
      type: String,
      default: ''
    },
    size: {
      required: false,
      type: [Number, String],
      default: 24
    },
    variant: {
      required: false,
      type: String,
      default: ''
    },
    asImage: {
      required: false,
      type: Boolean,
      default: false
    },
    fill: {
      type: String,
      default: 'currentColor'
    }
  },
  render(props, ctx) {
    var iconSize = typeof (this.size) === NaN ? 0 : Number(this.size);

    const iconVariant = this.variant;

    const mergedAttrs = merge(
      pick(props, ['fill']),
      ctx.attrs,
      {
        class: [
          'bi',
          this.variant ? iconVariant : {}
        ],
        style: {
          'pointer-events': 'auto'
        },
        width: iconSize,
        height: iconSize,
      }
    );

    return h(
      'svg',
      mergedAttrs,
      [
        h(this.asImage ? 'image' : 'use', {
          'href': this.icon + (this.path ? `#${this.path}` : ''),
          'xlink:href': this.icon + (this.path ? `#${this.path}` : ''),
          width: iconSize,
          height: iconSize,
        })
      ]
    );
  }
}
