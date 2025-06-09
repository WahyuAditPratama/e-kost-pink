package com.app.kostpink.activity;

import android.os.Bundle;
import android.view.MenuItem;
import android.view.View;
import android.widget.ProgressBar;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import com.app.kostpink.databinding.PreviewImageActivityBinding;
import com.bumptech.glide.Glide;

public class ImagePreviewActivity extends AppCompatActivity {

    String image;

     PreviewImageActivityBinding binding;
    ProgressBar progressBar;
String judul;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        binding = PreviewImageActivityBinding.inflate(getLayoutInflater());
        View getView = binding.getRoot();
        setContentView(getView);


        Bundle bundle = getIntent().getExtras();
        image = bundle.getString("url_images");
        judul = bundle.getString("title");
        getSupportActionBar().setTitle(judul);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);


        if (image.equals("")){
             //   binding.tvMelampirkanBukti.setVisibility(View.VISIBLE);
            } else {
                Glide.with(ImagePreviewActivity.this).load(image)
                        .centerCrop().fitCenter().into(binding.ivPreviewImage);
              //  binding.tvMelampirkanBukti.setVisibility(View.GONE);
            }
    }
    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        int back = item.getItemId();
        if (back == android.R.id.home){
            finish();
        }
        return super.onOptionsItemSelected(item);
    }
}