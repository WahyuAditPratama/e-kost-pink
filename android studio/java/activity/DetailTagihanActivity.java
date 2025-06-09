package com.app.kostpink.activity;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.app.kostpink.Config;
import com.app.kostpink.MainActivity;
import com.app.kostpink.R;
import com.app.kostpink.Rest.ApiClient;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.databinding.ActivityDetailBookingBinding;
import com.app.kostpink.model.ConfirmBookingResponse;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class DetailTagihanActivity extends AppCompatActivity {

    String imageUrl = Config.IMAGE_URL;
    SharedPrefManager sharedPrefManager;


    LinearLayout linear_status,linear_pembayaran;
    Button btn_proses;
    TextView tv_nama_customer,tv_payment_method,tv_payment_date,tv_payment_proof, tv_status,tv_email,tv_telepon,tv_tanggal,tv_nama_kamar,tv_deskripsi,tv_harga_bulanan,tv_periode,tv_due_date,  tv_catatan;
    TextView tv_lihat1,tv_lihat2;
    ActivityDetailBookingBinding binding;

  String id,no_invoice,bulan,tahun,nama_room,fitur,deskripsi,catatan, nama_customer,email,telepon,due_date,nominal,status,payment_method,payment_date,payment_proof,created_at,updated_at,id_customer,id_room,start_date,end_date,harga_bulanan,deposit_amount;

String visible;
    @RequiresApi(api = Build.VERSION_CODES.O)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail_tagihan);


        sharedPrefManager = new SharedPrefManager(this);
        nama_customer = sharedPrefManager.getCustomer().getNama_customer();
        email = sharedPrefManager.getCustomer().getEmail();
        telepon = sharedPrefManager.getCustomer().getTelepon();


        getSupportActionBar().setTitle("Detail Tagihan");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);



        Intent i = getIntent();
        id = i.getStringExtra("id");
        no_invoice = i.getStringExtra("no_invoice");
        bulan = i.getStringExtra("bulan");
        tahun = i.getStringExtra("tahun");
        due_date = i.getStringExtra("due_date");
        nominal = i.getStringExtra("nominal");
        status = i.getStringExtra("status");
        payment_method = i.getStringExtra("payment_method");
        payment_date = i.getStringExtra("payment_date");
        payment_proof = i.getStringExtra("payment_proof");
        created_at = i.getStringExtra("created_at");
        updated_at = i.getStringExtra("updated_at");
        id_customer = i.getStringExtra("id_customer");
        id_room = i.getStringExtra("id_room");
        start_date = i.getStringExtra("start_date");
        end_date = i.getStringExtra("end_date");
        harga_bulanan = i.getStringExtra("harga_bulanan");
        deposit_amount = i.getStringExtra("deposit_amount");
        nama_customer = i.getStringExtra("nama_customer");
        email = i.getStringExtra("email");
        telepon = i.getStringExtra("telepon");
        nama_room = i.getStringExtra("nama_room");
        fitur = i.getStringExtra("fitur");
        deskripsi = i.getStringExtra("deskripsi");
        visible = i.getStringExtra("visible");


        tv_nama_customer = findViewById(R.id.tv_nama_customer);
        tv_email = findViewById(R.id.tv_email);
        tv_telepon = findViewById(R.id.tv_telepon);
        tv_tanggal = findViewById(R.id.tv_tanggal);
        tv_nama_kamar = findViewById(R.id.tv_nama_kamar);
        tv_harga_bulanan = findViewById(R.id.tv_harga_bulanan);
        tv_periode = findViewById(R.id.tv_periode);
        tv_due_date = findViewById(R.id.tv_due_date);
        tv_payment_method = findViewById(R.id.tv_payment_method);
        tv_payment_date = findViewById(R.id.tv_payment_date);
         tv_catatan = findViewById(R.id.tv_catatan);
        tv_status=findViewById(R.id.tv_status);

        btn_proses=findViewById(R.id.btn_proses);
        linear_status = findViewById(R.id.linear_status);
        linear_pembayaran = findViewById(R.id.linear_pembayaran);

        tv_nama_customer.setText(nama_customer);
        tv_email.setText(email);
        tv_telepon.setText(telepon);
        tv_tanggal.setText(created_at);
        tv_nama_kamar.setText(nama_room);
        tv_harga_bulanan.setText(harga_bulanan);
        tv_periode.setText(start_date);
        tv_due_date.setText(due_date);
        tv_payment_method.setText(payment_method);
        tv_payment_date.setText(payment_date);
         tv_catatan.setText(catatan);






        if (status.equalsIgnoreCase("pending")) {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse));
            tv_status.setText("Menunggu Pembayaran");
            btn_proses.setVisibility(View.VISIBLE);
            linear_pembayaran.setVisibility(View.GONE);


        } else if (status.equalsIgnoreCase("proses")) {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse2));
            tv_status.setText("Menunggu Konfirmasi");
            btn_proses.setVisibility(View.GONE);
            linear_pembayaran.setVisibility(View.GONE);


        } else if (status.equalsIgnoreCase("paid")) {

            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse3));
            tv_status.setText("Sudah Dibayar");
            btn_proses.setVisibility(View.GONE);
            linear_pembayaran.setVisibility(View.GONE);



        }  else {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse5));
            tv_status.setText("Batal");
            btn_proses.setVisibility(View.GONE);
            linear_pembayaran.setVisibility(View.GONE);
        }


        btn_proses.setOnClickListener(v -> {
            Intent intent = new Intent(this, KonfirmasiPembayaranActivity.class);
            intent.putExtra("id", id);
            intent.putExtra("no_invoice", no_invoice);
            intent.putExtra("bulan", bulan);
            intent.putExtra("tahun", tahun);
            intent.putExtra("due_date", due_date);
            intent.putExtra("nominal", nominal);
            intent.putExtra("status",status);
            intent.putExtra("payment_method", payment_method);
            intent.putExtra("payment_date", payment_date);
            intent.putExtra("payment_proof",payment_proof);
            intent.putExtra("created_at", created_at);
            intent.putExtra("updated_at", updated_at);
            intent.putExtra("id_customer", id_customer);
            intent.putExtra("id_room", id_room);
            intent.putExtra("start_date", start_date);
            intent.putExtra("end_date", end_date);
            intent.putExtra("harga_bulanan", harga_bulanan);
            intent.putExtra("deposit_amount", deposit_amount);
            intent.putExtra("nama_customer",nama_customer);
            intent.putExtra("email", email);
            intent.putExtra("telepon",telepon);
            intent.putExtra("nama_room", nama_room);
            intent.putExtra("fitur", fitur);
            intent.putExtra("deskripsi", deskripsi);
            intent.putExtra("visible", "yes");
            startActivity(intent);
        });

    }


    public void sukses() {
        new AlertDialog.Builder(this).setTitle("Sukses").setMessage("Booking Berhasil Dibuat...").setNeutralButton("Tutup", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dlg, int sumthin) {
                Intent intent = new Intent(DetailTagihanActivity.this, MainActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                startActivity(intent);
                finish();
            }
        }).show();

    }
}


