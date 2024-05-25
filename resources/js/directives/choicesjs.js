var choice;

let handler = function(el, vnode) {
    // console.log(vnode);
    // console.log(choice.getValue(true));
};

const choicesjs = {
    mounted(el, binding, vnode, prevVnode) {
        const config = _.omit(
            _.merge({
                    removeItemButton: true,
                }, binding.value || {}
            ),
            ['onBooted', 'handleUserInput']
        );

        choice = new window.Choices(el, config);

        // handle any 'boot' stuff here
        if (typeof binding.value !== 'undefined') {
            // check if 'onBooted' method defined
            if (_.has(binding.value, 'onBooted')) {
                binding.value?.onBooted(choice);
            }
        }

        choice.input.element.addEventListener("keyup", function(event) {
            const inputVal = event.target.value;

            if (typeof binding.value !== 'undefined') {
                // check if 'handleUserInput' method defined
                if (_.has(binding.value, 'handleUserInput')) {
                    binding.value?.handleUserInput(
                        choice, inputVal, event
                    );
                }
            }
        });

        el.addEventListener("change", handler(el, vnode));
    },
    beforeUnmount(el, binding, vnode, prevVnode) {
        // handler(el, vnode)
    },
};

export default choicesjs;
