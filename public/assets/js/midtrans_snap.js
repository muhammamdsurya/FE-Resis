class MidTransSnap {
    constructor(snapToken) {
        this.snapToken = snapToken;
    }

    pay() {
        snap.pay(this.snapToken, {
            onSuccess: function (result) {
                Swal.fire("Success!", "Pembayaran Berhasil!", "success").then(
                    () => {
                        // Redirect to the desired route after the success message
                        window.location.href = "/user/kelas";
                    }
                );
            },
            onPending: function (result) {
                Swal.fire(
                    "Pending",
                    "Pembayaran kamu dalam status pending",
                    "question"
                ).then(() => {
                    // Redirect to the desired route after the success message
                    window.location.href = "/user/transaksi";
                });
            },
            onError: function (result) {
                Swal.fire("Oops!", "Pembayaran Gagal!", "error").then(() => {
                    // Redirect to the desired route after the success message
                    window.location.href = "/user/transaksi";
                });
            },
        });
    }
}
