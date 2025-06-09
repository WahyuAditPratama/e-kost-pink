package com.app.kostpink.activity;

import static com.app.kostpink.Config.IMAGE_URL;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.app.kostpink.Config;
import com.app.kostpink.MainActivity;
import com.app.kostpink.MainActivityAdmin;
import com.app.kostpink.R;
import com.app.kostpink.Rest.ApiClient;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.databinding.ActivityDetailBookingBinding;
import com.app.kostpink.model.ConfirmTagihanResponse;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class AdmDetailTagihanActivity extends AppCompatActivity {

    String imageUrl = Config.IMAGE_URL;
    SharedPrefManager sharedPrefManager;

    String filePath;
    LinearLayout linear_status,linear_pembayaran,linear_konfirmasi;
    Button btn_proses;
    TextView tv_nama_customer,tv_payment_method,tv_payment_date,tv_payment_proof, tv_status,tv_email,tv_telepon,tv_tanggal,tv_nama_kamar,tv_deskripsi,tv_harga_bulanan,tv_periode,tv_due_date,  tv_catatan;
    TextView tv_lihatbukti1;
    ActivityDetailBookingBinding binding;
    Spinner spinStatus;
    String[] arPil = {"terima", "tolak"};

  String id,no_invoice,bulan,tahun,nama_room,fitur,deskripsi,catatan, nama_customer,email,telepon,due_date,nominal,status,payment_method,payment_date,payment_proof,created_at,updated_at,id_customer,id_room,start_date,end_date,harga_bulanan,deposit_amount;

String visible;
    @RequiresApi(api = Build.VERSION_CODES.O)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.adm_activity_detail_tagihan);
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
        spinStatus=findViewById(R.id.spin_status);

        btn_proses=findViewById(R.id.btn_proses);
        linear_status = findViewById(R.id.linear_status);
        linear_pembayaran = findViewById(R.id.linear_pembayaran);
        linear_konfirmasi = findViewById(R.id.linear_konfirmasi);

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


        tv_lihatbukti1=findViewById(R.id.tv_lihatBukti1);
        tv_lihatbukti1.setOnClickListener(v -> {
            preview(payment_proof);
        });

        ArrayAdapter<String> dataAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, arPil);
        dataAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinStatus.setAdapter(dataAdapter);

        if (status.equalsIgnoreCase("pending")) {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse));
            tv_status.setText("Menunggu Pembayaran");
            btn_proses.setVisibility(View.GONE);
            linear_pembayaran.setVisibility(View.GONE);
            linear_konfirmasi.setVisibility(View.GONE);

        } else if (status.equalsIgnoreCase("proses")) {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse2));
            tv_status.setText("Menunggu Konfirmasi");
            btn_proses.setVisibility(View.VISIBLE);
            linear_pembayaran.setVisibility(View.VISIBLE);
            linear_konfirmasi.setVisibility(View.VISIBLE);


        } else if (status.equalsIgnoreCase("lunas")) {

            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse3));
            tv_status.setText("Sudah Dibayar");
            btn_proses.setVisibility(View.GONE);
            linear_pembayaran.setVisibility(View.VISIBLE);
            linear_konfirmasi.setVisibility(View.GONE);

        }  else {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse5));
            tv_status.setText("Ditolak");
            btn_proses.setVisibility(View.GONE);
            linear_pembayaran.setVisibility(View.GONE);
            linear_konfirmasi.setVisibility(View.GONE);

        }

        btn_proses.setOnClickListener(v -> {
            String id_tagihan = id;
            String status=spinStatus.getSelectedItem().toString();
            Call<ConfirmTagihanResponse> call = ApiClient
                    .getInstance()
                    .getApi()
                    .ConfrimTagihanAdm(id_tagihan, status);
            call.enqueue(new Callback<ConfirmTagihanResponse>() {
                @Override
                public void onResponse(Call<ConfirmTagihanResponse> call, Response<ConfirmTagihanResponse> response) {
                    ConfirmTagihanResponse ConfirmTagihanResponse = response.body();
                    if (ConfirmTagihanResponse.getStatus().equals("true")) {
                        sukses();
                    } else {
                        Toast.makeText(AdmDetailTagihanActivity.this,ConfirmTagihanResponse.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                }
                @Override
                public void onFailure(Call<ConfirmTagihanResponse> call, Throwable t) {
                    Toast.makeText(AdmDetailTagihanActivity.this, t.getMessage(), Toast.LENGTH_SHORT).show();
                }
            });
        });

    }


    public void sukses() {
        new AlertDialog.Builder(this).setTitle("Sukses").setMessage("Berhasil Konfirmasi Tagihan...").setNeutralButton("Tutup", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dlg, int sumthin) {
                Intent intent = new Intent(AdmDetailTagihanActivity.this, MainActivityAdmin.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                startActivity(intent);
                finish();
            }
        }).show();

    }

    private void preview(String filePath) {


        AlertDialog.Builder builder1 = new AlertDialog.Builder(AdmDetailTagihanActivity.this);
        builder1.setTitle("Bukti Bayar");
        final View lihatHasil = getLayoutInflater().inflate(R.layout.preview_image_activity, null);
        ImageView imageView = lihatHasil.findViewById(R.id.iv_previewImage);
        builder1.setView(lihatHasil);

        imageView.setVisibility(View.VISIBLE);

        Glide.with(this).load(IMAGE_URL + "bukti_bayar/" + payment_proof)
                .apply(new RequestOptions()).into(imageView);


        builder1.setPositiveButton("Tutup", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {
                dialogInterface.dismiss();
            }
        });
        builder1.show();


    }
}


