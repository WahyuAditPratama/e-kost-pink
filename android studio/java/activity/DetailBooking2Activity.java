package com.app.kostpink.activity;

import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.view.MenuItem;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;

import com.app.kostpink.Config;
import com.app.kostpink.R;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.databinding.ActivityDetailBookingBinding;

public class DetailBooking2Activity extends AppCompatActivity {

    String imageUrl = Config.IMAGE_URL;
    SharedPrefManager sharedPrefManager;


    LinearLayout linear_status,linear_pelapor;
    Button btn_proses;
TextView tv_nama_customer,tv_status,tv_email,tv_telepon,tv_tanggal,tv_nama_kamar,tv_deskripsi,tv_harga_bulanan,tv_start_date,tv_end_date,tv_catatan;
    TextView tv_lihat1,tv_lihat2;
    ActivityDetailBookingBinding binding;

    String id,id_customer,nama_customer, id_room, start_date, end_date, harga_bulanan, status, deposit_amount, catatan, created_at, updated_at,  nama_room, email, telepon, alamat, fitur, deskripsi;


String visible;
    @RequiresApi(api = Build.VERSION_CODES.O)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail_booking);


        sharedPrefManager = new SharedPrefManager(this);
        nama_customer = sharedPrefManager.getCustomer().getNama_customer();
        email = sharedPrefManager.getCustomer().getEmail();
        telepon = sharedPrefManager.getCustomer().getTelepon();

        getSupportActionBar().setTitle("Detail Booking");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);



        Intent i = getIntent();
        id = i.getStringExtra("id");
        id_customer = i.getStringExtra("id_customer");
        id_room = i.getStringExtra("id_room");
        start_date = i.getStringExtra("start_date");
        end_date = i.getStringExtra("end_date");
        harga_bulanan = i.getStringExtra("harga_bulanan");
        status = i.getStringExtra("status");
        deposit_amount = i.getStringExtra("deposit_amount");
        catatan = i.getStringExtra("catatan");
        created_at = i.getStringExtra("created_at");
        updated_at = i.getStringExtra("updated_at");
        nama_customer = i.getStringExtra("nama_customer");
        nama_room = i.getStringExtra("nama_room");
        email = i.getStringExtra("email");
        telepon = i.getStringExtra("telepon");
        alamat = i.getStringExtra("alamat");
        fitur = i.getStringExtra("fitur");
        deskripsi = i.getStringExtra("deskripsi");

        visible = i.getStringExtra("visible");

        tv_nama_customer = findViewById(R.id.tv_nama_customer);
        tv_email = findViewById(R.id.tv_email);
        tv_telepon = findViewById(R.id.tv_telepon);
        tv_tanggal = findViewById(R.id.tv_tanggal);
        tv_nama_kamar = findViewById(R.id.tv_nama_kamar);
        tv_deskripsi = findViewById(R.id.tv_deskripsi);
        tv_harga_bulanan = findViewById(R.id.tv_harga_bulanan);
        tv_start_date = findViewById(R.id.tv_start_date);
        tv_end_date = findViewById(R.id.tv_end_date);
        tv_catatan = findViewById(R.id.tv_catatan);


        linear_status = findViewById(R.id.linear_status);

        tv_nama_customer.setText(nama_customer);
        tv_email.setText(email);
        tv_telepon.setText(telepon);
        tv_tanggal.setText(created_at);
        tv_nama_kamar.setText(nama_room);
        tv_deskripsi.setText(deskripsi);
        tv_harga_bulanan.setText(harga_bulanan);
        tv_start_date.setText(start_date);
        tv_end_date.setText(end_date);
        tv_catatan.setText(catatan);






        if (status.equalsIgnoreCase("Proses")) {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse));
            tv_status.setText("Proses");

        } else if (status.equalsIgnoreCase("Valid")) {


            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse3));
            tv_status.setText("Valid");


        } else if (status.equalsIgnoreCase("Selesai")) {

            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse3));
            tv_status.setText("Selesai");


        }  else {
            //  btn_proses.setVisibility(View.GONE);

            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse5));
            tv_status.setText("Invalid");
        }
   //     Glide.with(this).load(Config.IMAGE_URL + "booking/" + preview_image).apply(new RequestOptions().override(480, 380)).into(img_gambar);
//        tv_lihat1 = findViewById(R.id.tv_lihatBukti1);
//        tv_lihat1.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View view) {
//                Intent intent = new Intent(DetailBookingActivity.this, ImagePreviewActivity.class);
//                intent.putExtra("url_images", imageUrl + "/booking/" + gambar);
//                intent.putExtra("title", "Foto Booking");
//                startActivity(intent);
//            }
//        });
//
//        tv_lihat2 = findViewById(R.id.tv_lihatBukti2);
//        tv_lihat2.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View view) {
//                Intent intent = new Intent(DetailBookingActivity.this, ImagePreviewActivity.class);
//                intent.putExtra("url_images", imageUrl + "/booking/" + foto_tindakan);
//                intent.putExtra("title", "Foto Tindakan");
//
//                startActivity(intent);
//            }
//        });



    }



    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        int back = item.getItemId();
        if (back == android.R.id.home) {
            finish();
        }
        return super.onOptionsItemSelected(item);
    }




}

       