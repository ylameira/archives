#include "Image.h"
#include "Load.h"
#include "Save.h"
#include "Convert.h"
#include <stdlib.h>
#include <iostream>
#include <fstream>
#include <vector>
#include <string>

#define MAX_INT 65536  // 2^16

using namespace std;

Image::Image(const string filename) { load(filename); }
Image::Image(Format f, string n, unsigned int w, unsigned int h, bool c, vector<Channel> C) {
	format = f;
	name = n;
	width = w;
	height = h;
	colored = c;
	channels = C;
	resizeData(width * height * channels.size());
}
Image::Image(const Image* image) {
	format = image->getFormat();
	name = image->getName();
	width = image->getWidth();
	height = image->getHeight();
	colored = image->isColored();
	channels = image->getChannels();
	resizeData(width * height * channels.size());
	for(unsigned int i=0 ; i < length ; i++) {
		data[i] = image->getData(i);
	}
}
Image::~Image() {/*TODO*/}

Format Image::getFormat() const { return format; }
string Image::getName() const { return name; }
unsigned int Image::getWidth() const { return width; }
unsigned int Image::getHeight() const { return height; }
bool Image::isColored() const { return colored; }
vector<Channel> Image::getChannels() const { return channels; }
unsigned int Image::getLength() const { return length; }
unsigned char Image::getData(int i) const { return data[i]; }
void Image::setData(int i, unsigned char value) { data[i] = value; }

bool Image::load(const string filename) {
	ifstream is(filename.c_str());
	if(!is) {
		return false;
	}
	
	string keyWord;
	is >> keyWord;
	is.close();
	
	if(keyWord.compare("P6") == 0) {
		format = PPM;
		name = filename;
		colored = true;
		return load_ppm(filename);
	}
	else if(keyWord.compare("RGBC") == 0) {
		format = RGBC;
		name = filename;
		colored = true;
		return load_rgbc(filename);
	}
	else if(keyWord.compare("YCCC") == 0) {
		format = YCCC;
		name = filename;
		colored = true;
		return load_yccc(filename);
	}
	else {
		return false;
	}
}

bool Image::save(const string filename, Format fileformat) const {
	if(fileformat == PPM) {
		if(format == PPM) {
			return save_ppm(filename);
		}
		else {
			return convertToPPM().save_ppm(filename);
		}
	}
	else if(fileformat == RGBC) {
		if(format == RGBC) {
			return save_rgbc(filename);
		}
		else {
			return convertToRGBC().save_rgbc(filename);
		}
	}
	else if(fileformat == YCCC) {
		if(format == YCCC) {
			return save_yccc(filename);
		}
		else {
			return convertToYCCC().save_yccc(filename);
		}
	}
	else {
		return false;
	}
}

void Image::resizeData(unsigned int length) {
	this->length = length;
	if((data = (unsigned char*)calloc(length, sizeof(unsigned char))) == NULL) {
		cout << "Allocation dynamique impossible" << endl;
		exit(EXIT_FAILURE);
	}
}