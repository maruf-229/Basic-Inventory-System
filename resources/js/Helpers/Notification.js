class Notification {
    success() {
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: 'Successfully Done!!',
            timeout: 1000
        }).show();
    }

    alert() {
        new Noty({
            type: 'alert',
            layout: 'topRight',
            text: 'Are You Sure?',
            timeout: 1000
        }).show();
    }

    error() {
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: 'Something Went Wrong!',
            timeout: 1000
        }).show();
    }

    warning() {
        new Noty({
            type: 'warning',
            layout: 'topRight',
            text: 'Opps Wrong!',
            timeout: 1000
        }).show();
    }

    image_validation() {
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: 'Upload Image Less than 1 MB',
            timeout: 1000
        }).show();
    }

    cart_success() {
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: 'Successfully Added!!',
            timeout: 1000
        }).show();
    }

    cart_delete() {
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: 'Successfully Removed!!',
            timeout: 1000
        }).show();
    }
}

export default Notification = new Notification();