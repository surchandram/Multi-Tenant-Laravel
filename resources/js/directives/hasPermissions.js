import { usePage } from '@inertiajs/vue3'

export default function(el, binding) {
    // collection of permissions
    const roles = usePage().props.auth.roles;
    const permissions = usePage().props.auth.permissions;
    const permissions_collection = usePage().props.auth.permissions_collection;

    const parseIdFromString = function(value) {
        var array = value.split(':', 2);

        return typeof array[1] === 'string' ? Number(array[1]) : undefined;
    }

    const parseType = function(value) {
        if (typeof value !== 'string') {
            return
        }

        var array = value.split(':', 2);

        return typeof array[0] === 'string' ? array[0] : undefined;
    }

    // passed permission
    const rawValue = binding.value;

    // check if array has giver
    const hasGiver = Array.isArray(rawValue);

    // get permission name/slug
    const permission = hasGiver ? rawValue[0] : rawValue;

    // get permission giver if possible
    const permitableId = hasGiver && typeof rawValue.length === 3 ? _.last(rawValue) : parseIdFromString(_.last(rawValue));

    // resolve giver tyoe
    var type;

    if (hasGiver && rawValue.length == 2) {
        type = parseType(_.last(rawValue));
    } else if (hasGiver && rawValue.length === 3) {
        type = _.last(rawValue);
    }

    // check for permission presence in user permissions
    let exists = _.find(permissions, function(model) {
        return model.name == permission || model.slug == permission;
    });

    // if permission not 'present' check in user's roles
    if (!exists) {
        // find permission from collection
        let filteredPermission = _.find(permissions_collection, ['name', permission]) ||
            _.find(permissions_collection, ['slug', permission]);

        // setup filter values
        let filterValues = {};

        if (type && permitableId) {
            filterValues = Object.assign({}, filterValues, { 'type': type, 'roleable_id': permitableId });
        }

        // filter matching user roles
        const filteredRoles = _.filter(filteredPermission.roles, function(role) {
            // determine if role is 'shareable' and if true run check against 'pivot.permitable_id'
            if (role.roleable_id === null && hasGiver) {
                return _.find(roles, (userRole) => {
                    return role.type === type && role.id === userRole.id && userRole.pivot.permitable_id === permitableId;
                });
            }

            return _.find(roles, Object.assign({}, filterValues, { 'id': role.id }));
        });

        exists = _.size(filteredRoles) > 0;
    }

    if (exists) {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}
