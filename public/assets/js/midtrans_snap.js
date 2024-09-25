class MidTransSnap{

    constructor(snapToken) {
        this.snapToken = snapToken;
    }

     pay(){
        snap.pay(this.snapToken, {
            onSuccess: function(result){
                Swal.fire(
                            'Sucess!',
                            'Pembayaran Berhasil !.',
                            'success'
                        );
            },
            onPending: function(result){
                Swal.fire({
                    title: "Pending?",
                    text: "Pembayaran kamu dalam status pending",
                    icon: "question"
                    });
            },
            onError: function(result){
                Swal.fire(
                            'Oops...',
                            'Pembayaran Gagal !.',
                            'error'
                        );
            },
            // onClose: function(){}
            })
    }
   
}